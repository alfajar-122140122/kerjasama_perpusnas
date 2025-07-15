<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

final class AdminDashboardControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testGuestCannotAccessAdminDashboard()
    {
        $result = $this->call('get', 'admin/dashboard');
        $result->assertRedirect();
        $result->assertSessionHas('error');
    }
} 