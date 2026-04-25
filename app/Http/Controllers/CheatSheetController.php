<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CheatSheetController extends Controller
{
    private function logos(): array
    {
        // keep your existing logos() array exactly as is
        return [ /* ... your SVG logos ... */];
    }

    private function getSheetData(): array
    {
        // keep your existing getSheetData() array exactly as is
        return [ /* ... your sections data ... */];
    }

    public function index()
    {
        $logos = $this->logos();
        $sheets = DB::table('cheat_sheets')->get();
        $tags = DB::table('cheat_sheet_tags')->get()->groupBy('cheat_sheet_id');

        $sheets = $sheets->map(function ($sheet) use ($logos, $tags) {
            return [
                'slug' => $sheet->slug,
                'title' => $sheet->title,
                'description' => $sheet->description,
                'color' => $sheet->color,
                'bg' => $sheet->bg,
                'topics' => $sheet->topics,
                'image' => $sheet->image,
                'svg' => $logos[$sheet->slug] ?? '',
                'tags' => isset($tags[$sheet->id])
                    ? $tags[$sheet->id]->pluck('tag')->toArray()
                    : [],
            ];
        })->toArray();

        return view('cheat-sheets', ['sheets' => $sheets]);
    }

    public function show(string $slug)
    {
        $logos = $this->logos();
        $listing = DB::table('cheat_sheets')->where('slug', $slug)->first();

        if (!$listing) {
            abort(404, "Cheat sheet '{$slug}' not found.");
        }

        $tags = DB::table('cheat_sheet_tags')
            ->where('cheat_sheet_id', $listing->id)
            ->pluck('tag')
            ->toArray();

        $sections = DB::table('cheat_sheet_sections')
            ->where('cheat_sheet_id', $listing->id)
            ->orderBy('sort_order')
            ->get();

        $sectionIds = $sections->pluck('id')->toArray();

        $allItems = DB::table('cheat_sheet_items')
            ->whereIn('section_id', $sectionIds)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section_id');

        $builtSections = $sections->map(function ($section) use ($allItems) {
            return [
                'title' => $section->title,
                'note' => $section->note,
                'items' => isset($allItems[$section->id])
                    ? $allItems[$section->id]->map(fn($i) => [
                        'label' => $i->label,
                        'code' => $i->code,
                        'note' => $i->note,
                    ])->toArray()
                    : [],
            ];
        })->toArray();

        $sheet = [
            'title' => $listing->title,
            'description' => $listing->description,
            'color' => $listing->color,
            'bg' => $listing->bg,
            'image' => $listing->image,
            'svg' => $logos[$slug] ?? '',
            'tags' => $tags,
            'sections' => $builtSections,
        ];

        // Add allSheets for the sidebar
        $allSheets = DB::table('cheat_sheets')
            ->select('id', 'slug', 'title', 'color', 'bg', 'image')
            ->orderBy('id')
            ->get()
            ->map(fn($s) => [
                'slug' => $s->slug,
                'title' => $s->title,
                'color' => $s->color,
                'bg' => $s->bg,
                'image' => $s->image ?? '',
                'svg' => $logos[$s->slug] ?? '',
            ]);

        return view('cheat-sheet-detail', [
            'sheet' => $sheet,
            'slug' => $slug,
            'allSheets' => $allSheets,
        ]);
    }

    public function download(string $slug)
    {
        $logos = $this->logos();
        $listing = DB::table('cheat_sheets')->where('slug', $slug)->first();

        if (!$listing) {
            abort(404, "Cheat sheet '{$slug}' not found.");
        }

        $tags = DB::table('cheat_sheet_tags')
            ->where('cheat_sheet_id', $listing->id)
            ->pluck('tag')
            ->toArray();

        $sections = DB::table('cheat_sheet_sections')
            ->where('cheat_sheet_id', $listing->id)
            ->orderBy('sort_order')
            ->get();

        $sectionIds = $sections->pluck('id')->toArray();

        $allItems = DB::table('cheat_sheet_items')
            ->whereIn('section_id', $sectionIds)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section_id');

        $builtSections = $sections->map(function ($section) use ($allItems) {
            return [
                'title' => $section->title,
                'note' => $section->note,
                'items' => isset($allItems[$section->id])
                    ? $allItems[$section->id]->map(fn($i) => [
                        'label' => $i->label,
                        'code' => $i->code,
                        'note' => $i->note,
                    ])->toArray()
                    : [],
            ];
        })->toArray();

        $sheet = [
            'title' => $listing->title,
            'description' => $listing->description,
            'color' => $listing->color,
            'bg' => $listing->bg,
            'image' => $listing->image,
            'svg' => $logos[$slug] ?? '',
            'tags' => $tags,
            'sections' => $builtSections,
        ];

        // Load the PDF view
        $pdf = Pdf::loadView('cheat-sheets.pdf', [
            'sheet' => $sheet,
            'slug' => $slug,
        ]);

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Download the PDF
        return $pdf->download($listing->title . ' - Cheat Sheet.pdf');
    }

     public function search(Request $request)
    {
        $searchQuery = $request->get('q', '');
        $tagFilter = $request->get('tag', '');
        $sortBy = $request->get('sort', 'relevance'); // relevance, title, newest
        
        $logos = $this->logos();
        
        // Start query builder
        $query = DB::table('cheat_sheets');
        
        // Apply search filter
        if (!empty($searchQuery)) {
            $searchTerms = explode(' ', $searchQuery);
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('title', 'like', "%{$term}%")
                             ->orWhere('description', 'like', "%{$term}%");
                    });
                }
            });
        }
        
        // Apply tag filter if specified
        if (!empty($tagFilter)) {
            $sheetIdsWithTag = DB::table('cheat_sheet_tags')
                ->where('tag', 'like', "%{$tagFilter}%")
                ->pluck('cheat_sheet_id')
                ->toArray();
            
            if (!empty($sheetIdsWithTag)) {
                $query->whereIn('id', $sheetIdsWithTag);
            } else {
                // No sheets with this tag, return empty result
                $query->whereRaw('1 = 0');
            }
        }
        
        // Apply sorting
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'newest':
                $query->orderBy('id', 'desc');
                break;
            case 'relevance':
            default:
                $query->orderBy('title', 'asc');
                break;
        }
        
        // Get filtered sheets
        $filteredSheets = $query->get();
        
        // Get tags for all sheets
        $allTags = DB::table('cheat_sheet_tags')->get()->groupBy('cheat_sheet_id');
        
        // Map sheets to required format
        $sheets = $filteredSheets->map(function ($sheet) use ($logos, $allTags) {
            // Get tags for this sheet
            $sheetTags = isset($allTags[$sheet->id])
                ? $allTags[$sheet->id]->pluck('tag')->toArray()
                : [];
            
            return [
                'slug' => $sheet->slug,
                'title' => $sheet->title,
                'description' => $sheet->description,
                'color' => $sheet->color,
                'bg' => $sheet->bg,
                'topics' => $sheet->topics,
                'image' => $sheet->image,
                'svg' => $logos[$sheet->slug] ?? '',
                'tags' => $sheetTags,
            ];
        })->toArray();
        
        // Get all unique tags for filter dropdown
        $allAvailableTags = DB::table('cheat_sheet_tags')
            ->select('tag')
            ->distinct()
            ->pluck('tag')
            ->toArray();
        
        // Return view with search results and filters
        return view('cheat-sheets', [
            'sheets' => $sheets,
            'searchQuery' => $searchQuery,
            'activeTag' => $tagFilter,
            'allTags' => $allAvailableTags,
            'sortBy' => $sortBy,
            'resultCount' => count($sheets),
        ]);
    }
}