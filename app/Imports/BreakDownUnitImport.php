<?php

namespace App\Imports;

use App\Models\BreakDownUnit;
use App\Models\BreakDownUnitPic;
use App\Models\Site;
use App\Models\Teknisi;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Pastikan Anda mengimpor ini

class BreakDownUnitImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        // Skip jika baris kosong atau 'code' kosong
        if (empty($row) || empty($row['code'])) {
            Log::warning('Row atau code kosong, melewatkan baris ini.');
            return null; // Melewatkan baris ini
        }

        try {
            // Cek apakah unit dengan unit_number ada
            $unit = Unit::where('unit_number', $row['code'])->first();
            if (!$unit) {
                Log::error('Unit tidak ditemukan: ' . $row['code']);
                throw new \Exception('Unit ' . $row['code'] . ' tidak ditemukan.');
            }

            // Cek apakah site ada
            $site = Site::where('name', $row['lokasi'])->first();
            if (!$site) {
                Log::error('Site tidak ditemukan: ' . $row['lokasi']);
                throw new \Exception('Site ' . $row['lokasi'] . ' tidak ditemukan.');
            }

            // Cek apakah tanggal dalam bentuk angka Excel (serial number)
            $tanggal = $this->convertExcelDateToCarbon($row['tanggal']);
            $startBddate = $this->convertExcelDateToCarbon($row['start_bd_date']);

            // Cek apakah PIC ada, jika kosong set menjadi array kosong
            $pic = isset($row['pic']) ? $row['pic'] : '';
            $pics = [];
            if (!empty($pic)) {
                // Memecah pic menjadi array berdasarkan koma jika ada, mengabaikan spasi
                $pics = preg_split('/\s*,\s*/', $pic); // Menggunakan regex untuk menangani pemisah koma
            }

            // Replace empty string values with 0 for numeric fields
            $hm_bd = empty($row['hm_bd']) ? 0 : $row['hm_bd'];
            $hm_ready = empty($row['hm_ready']) ? 0 : $row['hm_ready'];
            $duration_bd = empty($row['duration_bd']) ? 0 : $row['duration_bd'];

            // Simpan data breakdown unit terlebih dahulu
            $breakdownUnit = new BreakDownUnit([
                'tanggal' => $tanggal,
                'shift' => $row['shift'],
                'unit' => $unit->unit_number,
                'pit' => $row['pit'],
                'site_id' => $site->id,
                'hm_bd' => $hm_bd,  // Pastikan ini adalah angka
                'hm_ready' => $hm_ready,  // Pastikan ini adalah angka
                'start_bd_date' => $startBddate,
                'start_bd' => $row['start_bd'],
                'end_bd' => $row['end_bd'],
                'duration_bd' => $duration_bd,  // Pastikan ini adalah angka
                'status_bd' => $row['status_bd'],
                'problem' => $row['problem'],
                'action' => $row['action'],
                'pb_vendor' => $row['pbvendor'],
                'mr_ro_po' => $row['mrropo'],
                'section' => $row['section'],
                'component' => $row['component'],
                'company_id' => auth()->user()->company->id
            ]);

            // Simpan breakdown unit terlebih dahulu
            $breakdownUnit->save();

            // Mengelola relasi PIC (Teknisi) melalui tabel pivot
            foreach ($pics as $picName) {
                // Trim untuk memastikan tidak ada spasi ekstra
                $picName = trim($picName);
                if (empty($picName)) {
                    continue; // Skip jika PIC kosong atau hanya spasi
                }

                // Cari teknisi berdasarkan nama
                $technician = Teknisi::where('nama', $picName)->first();
                if (!$technician) {
                    Log::error('Teknisi tidak ditemukan: ' . $picName);
                    throw new \Exception('Teknisi ' . $picName . ' tidak ditemukan.');
                }

                // Relasikan teknisi dengan breakdown unit melalui tabel pivot
                BreakDownUnitPic::create([
                    'teknisi_id' => $technician->id,
                    'breakdown_unit_id' => $breakdownUnit->id,
                ]);
            }

            return $breakdownUnit; // Mengembalikan breakdown unit yang sudah disimpan
        } catch (\Exception $e) {
            Log::error('Error di model: ' . $e->getMessage());
            // Melempar exception untuk di-catch oleh import method
            throw $e; 
        }
    }

    // Fungsi untuk mengonversi angka Excel menjadi Carbon Date
    private function convertExcelDateToCarbon($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Jika nilai adalah angka (Excel Date Serial Number)
            $dateTime = Date::excelToDateTimeObject($excelDate); // Menggunakan PhpSpreadsheet
            return \Carbon\Carbon::instance($dateTime); // Mengonversi ke Carbon
        } elseif ($excelDate) {
            // Jika nilai sudah dalam format string tanggal biasa
            return \Carbon\Carbon::parse($excelDate);
        }

        return null; // Jika tanggal kosong atau tidak valid
    }
}

