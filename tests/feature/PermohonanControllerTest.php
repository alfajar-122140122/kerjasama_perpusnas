<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

final class PermohonanControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testPengajuanPageLoads()
    {
        $result = $this->call('get', 'kerja-sama/pengajuan');
        $result->assertStatus(200);
        $result->assertSee('Permohonan Kerja Sama'); // Sesuaikan dengan konten halaman
    }

    public function testPengajuanValidationFails()
    {
        $result = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest'
        ])->call('post', 'kerja-sama/pengajuan/submit', [
            'jenis_permohonan' => '',
            'lembaga' => '',
            'alamat' => '',
            'telp' => '',
            'email' => '',
            'unit_terkait' => '',
            'kontak' => '',
            // Tidak mengirim file formulir
        ]);
        $result->assertJSONFragment(['status' => false]);
        $result->assertJSONFragment(['message' => 'Validation failed']);
    }
} 