<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\BeritaModel;

final class BeritaModelTest extends CIUnitTestCase
{
    public function testModelInstance()
    {
        $model = new BeritaModel();
        $this->assertInstanceOf(BeritaModel::class, $model);
    }

    public function testAllowedFields()
    {
        $model = new BeritaModel();
        $this->assertContains('judul', $model->allowedFields);
    }
} 