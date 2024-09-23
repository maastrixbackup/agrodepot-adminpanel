<?php

namespace App\Http\Controllers;

use App\Models\BackupDb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $backupDbs = BackupDb::orderBy('created', 'desc')->paginate(10);
        return view('backup.list', compact('backupDbs'));
    }


    public function createBackup()
    {
        $tables = DB::select('SHOW TABLES');
        $sqlData = '';

        foreach ($tables as $table) {
            $tableName = reset($table);

            if ($tableName != 'backup_db' && $tableName != 'admin_langs') {
                $tableStructure = DB::select('SHOW CREATE TABLE ' . $tableName);
                $sqlData .= 'DROP TABLE IF EXISTS ' . $tableName . ";\n";
                $sqlData .= $tableStructure[0]->{'Create Table'} . ";\n\n";

                $tableData = DB::table($tableName)->get();

                foreach ($tableData as $row) {
                    $rowData = collect($row)->map(function ($item) {
                        return '"' . addslashes($item) . '"';
                    })->implode(',');

                    $sqlData .= 'INSERT INTO ' . $tableName . ' VALUES(' . $rowData . ");\n";
                }
                $sqlData .= "\n";
            }
        }

        $backupFile = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $backupPath = public_path('uploads/backup_db/' . $backupFile);

        file_put_contents($backupPath, $sqlData);

        $backupDb = new BackupDb();
        $backupDb->backup_file = $backupFile;
        $backupDb->created = now();
        $backupDb->save();

        return response()->json(['message' => 'Backup created successfully.']);
    }


    public function restoreBackup(Request $request)
    {
        $filename = $request->filename;
        $path = public_path('uploads/backup_db/' . $filename);

        if (file_exists($path)) {
            $contents = file_get_contents($path);
            $queries = explode(';', $contents);

            foreach ($queries as $query) {
                if (!empty(trim($query))) {
                    try {
                        DB::unprepared($query);
                    } catch (\Exception $e) {
                        return response()->json(['message' => 'Error restoring backup: ' . $e->getMessage()], 500);
                    }
                }
            }

            return response()->json(['message' => 'Backup restored successfully.']);
        }

        return response()->json(['message' => 'Backup file not found.'], 404);
    }



    public function deleteBackup(Request $request)
    {
        $backupDb = BackupDb::find($request->backup_id);
        // dd($backupDb);
        if ($backupDb) {

            $path = public_path('uploads/backup_db/' . $backupDb->backup_file);
            if (file_exists($path)) {
                unlink($path);
            }

            $backupDb->delete();
            return response()->json(['message' => 'Backup deleted successfully.']);
        }
        return response()->json(['message' => 'Backup not found.'], 404);
    }




    // public function downloadBackup($filename)
    // {
    //     $path = 'uploads/backup_db/' . $filename;

    //     if (file_exists($path)) {
    //         return response()->download($path);
    //     }

    //     return response()->json(['message' => 'Backup file not found.'], 404);
    // }
}
