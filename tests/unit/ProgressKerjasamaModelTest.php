<?php
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\ProgressKerjasamaModel;

final class ProgressKerjasamaModelTest extends CIUnitTestCase
{
    public function testModelInstance()
    {
        $model = new ProgressKerjasamaModel();
        $this->assertInstanceOf(ProgressKerjasamaModel::class, $model);
    }

    public function testGetProgressDataReturnsArray()
    {
        $model = new ProgressKerjasamaModel();
        $result = $model->getProgressData();
        $this->assertIsArray($result);
    }
} 