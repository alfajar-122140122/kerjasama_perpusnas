<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

final class AuthControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testLoginPageLoads()
    {
        $result = $this->call('get', 'auth/login');
        $result->assertStatus(200);
        $result->assertSee('Login'); // Pastikan ada kata 'Login' di halaman
    }

    public function testLoginValidationFails()
    {
        $result = $this->call('post', 'auth/login', [
            'username' => '', // Kosong, harusnya gagal
            'password' => ''
        ]);
        $result->assertSee('required'); // Cari pesan error validasi
    }

    public function testGuestCannotAccessAdmin()
    {
        $result = $this->call('get', 'admin/dashboard');
        $result->assertRedirect(); // Harus redirect ke login
        $result->assertSessionHas('error'); // Ada pesan error di session
    }
} 