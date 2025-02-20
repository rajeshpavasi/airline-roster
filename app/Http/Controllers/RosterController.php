<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RosterController extends Controller
{
    public function uploadRoster(Request $request)
    {
        $file = $request->file('roster');
        $extension = $file->getClientOriginalExtension();
        
        if (!in_array($extension, ['pdf', 'xlsx', 'txt', 'html', 'ics'])) {
            return response()->json(['error' => 'Unsupported file format'], 400);
        }

        
        if ($extension === 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->path());
            $content = $pdf->getText();
            foreach (explode("\n", $content) as $datum) { 
                foreach (explode(" ", $datum) as $line) { 
               
                if (preg_match('/(DO|SBY|FLT|CI|CO|UNK)\s+([A-Z]{2}\d+)/', $line, $matches)) {
                  $data =   Roster::create([
                        'type' => $matches[1],
                        'flight_number' => $matches[2] ?? null,
                        'start_time' => now(),
                        'end_time' => now(),
                    ]);
                }
            }}
        }elseif($extension === 'txt'){
           
            $content =  file_get_contents($file);
            foreach (explode("\n", $content) as $datum) { 
                foreach (explode(" ", $datum) as $line) { 
                if (preg_match('/(DO|SBY|FLT|CI|CO|UNK)\s+([A-Z]{2}\d+)/', $line, $matches)) {
                  $data =   Roster::create([
                        'type' => $matches[1],
                        'flight_number' => $matches[2] ?? null,
                        'start_time' => now(),
                        'end_time' => now(),
                    ]);
                }
            }}
        }elseif ($extension === 'xlsx' || $extension === 'xls' ) {
            
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            array_shift($sheetData);
            foreach ($sheetData as $datum) { 
               foreach($datum as $line){
                if (preg_match('/(DO|SBY|FLT|CI|CO|UNK)\s+([A-Z]{2}\d+)/', $line, $matches)) {
                  $data =   Roster::create([
                        'type' => $matches[1],
                        'flight_number' => $matches[2] ?? null,
                        'start_time' => now(),
                        'end_time' => now(),
                    ]);
                }
            }}            
        }else{}

        return response()->json(['message' => 'Roster uploaded and parsed']);
    }
}
