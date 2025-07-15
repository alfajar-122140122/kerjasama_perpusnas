<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\ImplementasiKerjasamaModel;

final class ImplementasiKerjasamaModelTest extends CIUnitTestCase
{
    public function testModelInstance()
    {
        $model = new ImplementasiKerjasamaModel();
        $this->assertInstanceOf(ImplementasiKerjasamaModel::class, $model);
    }

    public function testGetImplementasiWithKerjasamaReturnsArray()
    {
        $model = new ImplementasiKerjasamaModel();
        $result = $model->getImplementasiWithKerjasama();
        $this->assertIsArray($result);
    }
} 