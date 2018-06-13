<?php
namespace Controller;

use Model;

/**
 * MusicController Class
 */
class MainController
{

    /**
     * Get all cds data
     *
     * @return array
     */
    public function getMusicCDs() {
        $model = new Model\MusicModel();
        return $model->findAll();
    }

    /**
     * Get CD data by ID
     *
     * @param $id
     * @return array
     */
    public function getMusicCDByID($id) {
        if (is_numeric($id)) {
            $model = new Model\MusicModel();
            return $model->findByColumn('id', $id);
        }
    }

    /**
     * Create new record
     *
     * @param array $data
     *  example: array ('cd_artist_name' => 'name')
     *
     * @return bool|mixed
     */
    public function createCDRecord($data = array()) {
        if (!empty($data)) {
            $model = new Model\MusicModel();
            return $model->addRecord($data);
        }
    }

    public function deleteRecord($id) {
        if (!empty($id)) {
            $model = new Model\MusicModel();
            return $model->deleteRecord($id);
        }
    }
}

