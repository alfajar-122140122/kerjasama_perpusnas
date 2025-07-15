<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

final class PublicHomeControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomePageLoads()
    {
        $result = $this->call('get', '/');
        $result->assertStatus(200);
        $result->assertSee('Statistik Kerja Sama'); // Sesuaikan dengan konten homepage
    }

    public function testTentangPageLoads()
    {
        $result = $this->call('get', 'tentang');
        $result->assertStatus(200);
        $result->assertSee('Tentang'); // Sesuaikan dengan konten tentang
    }

    public function testKontakPageLoads()
    {
        $result = $this->call('get', 'kontak');
        $result->assertStatus(200);
        $result->assertSee('Kontak'); // Sesuaikan dengan konten kontak
    }
} 