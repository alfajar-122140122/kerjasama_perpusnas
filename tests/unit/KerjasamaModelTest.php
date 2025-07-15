<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\KerjasamaModel;

final class KerjasamaModelTest extends CIUnitTestCase
{
    public function testModelInstance()
    {
        $model = new KerjasamaModel();
        $this->assertInstanceOf(KerjasamaModel::class, $model);
    }

    public function testAllowedFields()
    {
        $model = new KerjasamaModel();
        $this->assertContains('nama_mitra', $model->allowedFields);
    }
} 