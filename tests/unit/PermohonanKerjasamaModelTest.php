<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\PermohonanKerjasamaModel;

final class PermohonanKerjasamaModelTest extends CIUnitTestCase
{
    public function testModelInstance()
    {
        $model = new PermohonanKerjasamaModel();
        $this->assertInstanceOf(PermohonanKerjasamaModel::class, $model);
    }

    public function testGetByStatusReturnsArray()
    {
        $model = new PermohonanKerjasamaModel();
        $result = $model->getByStatus('pending');
        $this->assertIsArray($result);
    }
} 