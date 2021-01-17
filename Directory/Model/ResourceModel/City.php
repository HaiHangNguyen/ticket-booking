<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ticket\Directory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class City
 *
 * @package Ticket\Directory\Model\ResourceModel
 */
class City extends AbstractDb
{
    const MAIN_TABLE = 'directory_city_entity';

    public function getDefaultNameById($cityId)
    {
        $select = $this->getConnection()->select();
        try {
            $select->from($this->getMainTable(), 'default_name');
            $select->where("city_id = :city_id");
            $result = $this->getConnection()->fetchOne($select, ['city_id' => $cityId]);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result = "";
        }

        return $result ?: "";
    }

    /**
     * Create multiple
     *
     * @param array $cities
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function createMultiple($cities = [])
    {
        $resultData = [];

        foreach ($cities as $city) {
            $resultData[] = [
                'country_id' => 'VN',
                'code' => $city['code'],
                'name' => $city['name'],
                'default_name' => $city['name_with_type']
            ];
        }

        $this->getConnection()->insertMultiple($this->getMainTable(), $resultData);
        $query = $this->getConnection()->select()->from(['e' => $this->getMainTable()], ['code', 'city_id']);
        $cities = [];

        foreach ($this->getConnection()->fetchAll($query) as $record) {
            $cities[$record['code']] = $record['city_id'];
        }

        return $cities;
    }

    public function getCityCodeWithId($cityId)
    {
        $select = $this->getConnection()->select();
        $select->from($this->getTable(self::MAIN_TABLE), 'code');
        $select->where('city_id = :city_id');
        $code = $this->getConnection()->fetchOne($select, ['city_id' => $cityId]);

        return $code ?: $cityId;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('directory_city_entity', 'city_id');
    }

}
