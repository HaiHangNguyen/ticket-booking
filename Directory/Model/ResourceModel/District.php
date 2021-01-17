<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ticket\Directory\Model\ResourceModel;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Class District
 * @package Ticket\Directory\Model\ResourceModel
 */
class District extends AbstractDb
{
    const MAIN_TABLE = 'directory_district_entity';

    public function getDefaultNameById($districtId)
    {
        $select = $this->getConnection()->select();
        try {
            $select->from($this->getMainTable(), 'default_name');
            $select->where("district_id = :district_id");
            $result = $this->getConnection()->fetchOne($select, ['district_id' => $districtId]);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result = "";
        }

        return $result ?: "";
    }

    public function getDistrictCodeWithId($districtId)
    {
        $select = $this->getConnection()->select();
        $select->from($this->getTable(self::MAIN_TABLE), 'code');
        $select->where('district_id = :district_id');
        $code = $this->getConnection()->fetchOne($select, ['district_id' => $districtId]);

        return $code ?: $districtId;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('directory_district_entity', 'district_id');
    }

    /**
     * Create multiple
     *
     * @param array $districts
     * @param array $cites
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createMultiple($districts = [], array $cites = [])
    {
        $resultData = [];

        foreach ($districts as $district) {
            $resultData[] = [
                'city_id' => @$cites[$district['parent_code']],
                'code' => $district['code'],
                'name' => $district['name'],
                'default_name' => $district['name_with_type']
            ];
        }

        $this->getConnection()->insertMultiple($this->getMainTable(), $resultData);
        $query = $this->getConnection()->select()->from(['e' => $this->getMainTable()], ['code', 'district_id']);
        $districts = [];

        foreach ($this->getConnection()->fetchAll($query) as $record) {
            $districts[$record['code']] = $record['district_id'];
        }

        return $districts;
    }

}
