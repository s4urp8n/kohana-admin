<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Model_Admin extends Model
{

    public static function getSharedModelUploads($model, $primary, $key)
    {
        $files = self::getModelUploads($model, $primary, $key);
        $len = mb_strlen(DOCROOT);
        foreach ($files as $key => $file) {
            $files[$key] = DIRECTORY_SEPARATOR . mb_substr($file, $len);
            $files[$key] = mb_eregi_replace('\\\\', '/', $files[$key]);
        }

        return $files;
    }

    public static function getModelUploads($model, $primary, $key)
    {
        $files = [];
        $data = $model->getEditData($primary);
        if (!empty($data) && !empty($data['uploadsDirs']) && !empty($data['uploadsDirs'][$key])) {
            $dir = Admin::getFullUploadsPath() . $data['uploadsDirs'][$key]['directory'];
            if (file_exists($dir) && is_dir($dir)) {
                $files = Admin::getScandir($dir, null, false, true);
            }
        }

        return $files;
    }

    public static function filterData(&$data, $model)
    {
        if (!empty($data)) {
            $unfilteredColumns = [];
            if (method_exists($model, 'getUnfilteredColumns')) {
                $unfilteredColumns = $model->getUnfilteredColumns();
            }

            $filterParams = AdminHREF::getFilterParams();
            if (!empty($filterParams)) {

                foreach ($filterParams as $filter => $filterValue) {
                    if (!is_array($filterValue)) {
                        $filterValue = [$filterValue];
                    }
                    foreach ($data as $key => $rows) {
                        if (array_key_exists($filter, $rows)) {
                            if (!in_array($rows[$filter], $filterValue)) {
                                unset($data[$key]);
                            }
                        }
                    }
                }
            }
        }
    }

    public static function getDistinctSubArrayKeyValues(&$array, $key)
    {
        $result = [];
        foreach ($array as $subarray) {

            foreach ($subarray as $k => $value) {
                if ($k === $key) {
                    $result[] = $value;
                }
            }
        }

        return array_unique($result);
    }

    public function deleteUploads($object, $id)
    {
        try {

            if (!empty($id)) {
                $dir = '';
                $class = get_class($object);
                $params = $class::getUploadsParams($id);
                foreach ($params as $param) {
                    $dir = Admin::getFullUploadsPath() . $param['directory'];
                    DirectoryManipulator::removeDirectory($dir);
                }
            }
        }
        catch (Exception $e) {
        }
    }

    public function getUploadsMaxSizeInBytes($directoryIndex, $primary)
    {
        $size = 0;
        $data = $this->getEditData($primary);
        if (!empty($data) && !empty($data['uploadsDirs']) && !empty($data['uploadsDirs'][$directoryIndex])) {
            $data = $data['uploadsDirs'][$directoryIndex];
            $modelSize = null;
            if (!empty($data['uploadMaxSize']) && is_numeric($data['uploadMaxSize']) && $data['uploadMaxSize'] > 0) {
                $modelSize = intval($data['uploadMaxSize']);
            }
            $size = Admin::getMaximumFileUploadSize($modelSize);
        }

        return Text::bytes($size);
    }

    public function isAllowed()
    {
        $auth = Auth::instance();
        $roles = $auth->getRoles();
        $allowed = $this->getAllowedRoles();

        $intersect = array_intersect($allowed, $roles);

        if (empty($allowed) || (!empty($allowed) && !empty($intersect))) {
            return true;
        }

        return false;
    }

    public function getAllowedRoles()
    {
        return ['admin'];
    }

    public function getHREF()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }

    public function getCaption()
    {
        $info = $this->getInfo();
        $icon = '<i class="fa fa-circle"></i>';
        if (!empty($info['icon'])) {
            $icon = $info['icon'];
        }

        return $icon . ' ' . $info['caption'];
    }

    public function getInfo()
    {
        $message = "Model " . get_class($this) . " must contain " . __FUNCTION__ . " method.";
        throw new Exception($message);
    }

    public function getActionButtons()
    {

        $buttons = [];
        $ref = urlencode(AdminHREF::getFullCurrentHREF());

        $edit = function ($row) use ($ref) {
            $href = AdminHREF::getDefaultAdminRouteUri('dataEdit', $this->getShortName(), $row['id']) . '/?ref=' . $ref;
            $text = '<i class="fa fa-pencil gc"></i>';

            return '<a class="editHref"  title="Редактировать"  href="' . $href . '">' . $text . '</a>';
        };

        $delete = function ($row) use ($ref) {
            $href =
                AdminHREF::getDefaultAdminRouteUri('dataDelete', $this->getShortName(), $row['id']) . '/?ref=' . $ref;
            $text = '<i class="fa fa-trash-o gc"></i>';

            return '<a class="delHref confirm" title="Удалить" confirmText="Вы уверены в удалении товара?" href="'
                   . $href . '">' . $text . '</a>';
        };

        if ($this->isModifyingAllowed()) {
            $buttons['Редактировать'] = $edit;
        }

        if ($this->isDeletionAllowed()) {
            $buttons['Удалить'] = $delete;
        }

        return $buttons;
    }

    public function getShortName()
    {
        $class = get_class($this);
        $parts = explode('_', $class);

        return array_pop($parts);
    }

    public function isModifyingAllowed()
    {
        $currentRoles = Auth::instance()
                            ->getRoles();
        $modifyingRoles = $this->getModifyingRoles();
        $intersect = array_intersect($modifyingRoles, $currentRoles);
        if (empty($modifyingRoles) || (!empty($modifyingRoles) && !empty($intersect))) {
            return true;
        }

        return false;
    }

    public function isDeletionAllowed()
    {
        $currentRoles = Auth::instance()
                            ->getRoles();
        $deletionRoles = $this->getDeletionRoles();
        $intersect = array_intersect($deletionRoles, $currentRoles);
        if (empty($deletionRoles) || (!empty($deletionRoles) && !empty($intersect))) {
            return true;
        }

        return false;
    }

    public function getModifyingRoles()
    {
        return ['admin'];
    }

    public function getDeletionRoles()
    {
        return ['admin'];
    }

}
