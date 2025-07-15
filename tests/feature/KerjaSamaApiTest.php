<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

final class KerjaSamaApiTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testApiKerjasamaReturnsJson()
    {
        $result = $this->call('get', 'api/kerjasama');
        $result->assertStatus(200);
        $result->assertHeader('Content-Type', 'application/json; charset=UTF-8');
        $result->assertJSONFragment(['success' => true]);
        $result->assertJSON(function($json) {
            $this->assertArrayHasKey('data', $json);
            $this->assertIsArray($json['data']);
            if (count($json['data']) > 0) {
                $item = $json['data'][0];
                $this->assertArrayHasKey('id', $item);
                $this->assertArrayHasKey('nama_mitra', $item);
                $this->assertArrayHasKey('ruang_lingkup', $item);
                $this->assertArrayHasKey('tanggal_mulai', $item);
                $this->assertArrayHasKey('tanggal_berakhir', $item);
                $this->assertArrayHasKey('created_at', $item);
                $this->assertArrayHasKey('updated_at', $item);
            }
        });
    }

    public function testApiKerjasamaEmptyData()
    {
        // Hapus data child dan parent dengan where('1=1')->delete() agar tidak error di CodeIgniter
        $db = \Config\Database::connect();
        $db->table('implementasi_kerjasama')->where('1=1')->delete();
        $db->table('kerjasama')->where('1=1')->delete();
        $result = $this->call('get', 'api/kerjasama');
        $result->assertStatus(200);
        $result->assertHeader('Content-Type', 'application/json; charset=UTF-8');
        $result->assertJSONFragment(['success' => true]);
        $result->assertJSON(function($json) {
            $this->assertArrayHasKey('data', $json);
            $this->assertIsArray($json['data']);
            $this->assertCount(0, $json['data']);
        });
    }
} 