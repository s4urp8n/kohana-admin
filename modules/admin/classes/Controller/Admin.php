<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template
{
    
    public $template = 'Admin/Template';
    public $auth = null;
    public $model = null;
    public $params = [];
    public $query = [];
    
    public function action_changeVisible()
    {
        if ($this->check(['isAllowed', 'isModifyingAllowed']) === true && !empty($_POST))
        {
            if (!empty($_POST['model']) && !empty($_POST['id'])
                && in_array(
                    $_POST['visible'], [
                                         0,
                                         1,
                                     ]
                )
            )
            {
                try
                {
                    
                    $model = htmlentities($_POST['model']);
                    $id = htmlentities($_POST['id']);
                    $visible = htmlentities($_POST['visible']);
                    $model = ORM::factory($model, $id);
                    if (!empty($model->id))
                    {
                        $model->visible = $visible;
                        $model->save();
                    }
                }
                catch (Exception $e)
                {
                }
            }
        }
        die();
    }
    
    public function check(
        array $allowes = ['isAllowed'], array $methodsExists = [], array $mandatoryRequestParams = [],
        array $mandatoryQueryParams = [], $additionalCondition = null
    ) {
        
        $additional = false;
        
        if (!is_null($additionalCondition))
        {
            $additional = $additionalCondition;
        }
        
        $message =
            'Возможные причины: ' . '<br/> - Модель не найдена; ' . '<br/> - Модель не соответствует требованиям; '
            . '<br/> - Недостаточно прав для доступа.' . '<br/>';
        $shortModelName = Request::initial()
                                 ->param('param');
        
        $valid = $additional;
        if (!empty($shortModelName))
        {
            $model = Admin::createModel('Model_Admin_' . $shortModelName);
            if (!empty($model))
            {
                $valid = true;
                foreach ($allowes as $allow)
                {
                    if (!method_exists($model, $allow) || !$model->$allow())
                    {
                        $valid = $additional;
                    }
                }
                
                foreach ($methodsExists as $method)
                {
                    if (!method_exists($model, $method))
                    {
                        $valid = $additional;
                    }
                }
            }
        }
        
        foreach ($mandatoryRequestParams as $value)
        {
            $param = $this->request->param($value);
            if (is_null($param))
            {
                $valid = $additional;
                $this->params = [];
                break;
            }
            else
            {
                $this->params[$value] = $param;
            }
        }
        
        foreach ($mandatoryQueryParams as $value)
        {
            if (!isset($_GET[$value]))
            {
                $valid = $additional;
                $this->query = [];
                break;
            }
            else
            {
                $this->query[$value] = $_GET[$value];
            }
        }
        
        if ($valid)
        {
            $this->model = $model;
            
            return true;
        }
        $this->template->content = self::getDefaultMenu() . AdminHTML::renderMessage($message, 'danger', 'Ошибка!');
    }
    
    public static function getDefaultMenu()
    {
        $menuItems = [self::getMainMenu()];
        $menuItems[] = self::getSiteMenu();
        $menuItems[] = self::getLogoutMenu();
        $menu = View::factory('Admin/Menu/Template', ['items' => $menuItems]);
        
        return $menu;
    }
    
    public static function getMainMenu()
    {
        return [
            'caption' => 'Меню',
            'href'    => AdminHREF::getDefaultAdminRouteUri('menu'),
            'icon'    => '<i class="fa fa-list"></i>',
        ];
    }
    
    public static function getSiteMenu()
    {
        return [
            'caption' => 'Открыть сайт',
            'target'  => 'blank',
            'href'    => AdminHREF::getFullHost(),
            'icon'    => '<i class="fa fa-external-link-square"></i>',
        ];
    }
    
    public static function getLogoutMenu()
    {
        $auth = Auth::instance();
        $user = $auth->get_user();
        $user = $user->username;
        
        return [
            'caption' => $user . ' [выйти]',
            'href'    => AdminHREF::getDefaultAdminRouteUri('logout'),
            'icon'    => '<i class="fa fa-sign-out"></i>',
        ];
    }
    
    public function action_fileman()
    {
        if ($this->check() === true)
        {
            
            $menuItems = [self::getMainMenu()];
            
            $menuItems[] = [
                'href'    => AdminHREF:: getFullCurrentHREF(),
                'caption' => $this->model->getCaption(),
            ];
            
            $content = View::factory('Admin/Fileman/fileman');
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function action_ajaxeditor()
    {
        if (!empty($_FILES['imageupload']['name']))
        {
            if (!$_FILES['imageupload']['error'])
            {
                $name = md5($_FILES['imageupload']['name']);
                $ext = pathinfo($_FILES['imageupload']['name'], PATHINFO_EXTENSION);
                $filename = $name . '.' . $ext;
                $destinationDir = Admin::getConfig('sharedDir') . DIRECTORY_SEPARATOR . Admin::getConfig('uploadsDir')
                                  . DIRECTORY_SEPARATOR . 'editorUploads' . DIRECTORY_SEPARATOR;
                
                if (!file_exists($destinationDir))
                {
                    mkdir($destinationDir, 0755, true);
                }
                
                $destination = $destinationDir . $filename;
                if (move_uploaded_file($_FILES["imageupload"]["tmp_name"], $destination))
                {
                    echo AdminHREF::getFullHost() . '/' . $destination;
                }
            }
        }
        die();
    }
    
    public function action_menu()
    {
        
        $menu = View:: factory(
            'Admin/Menu/Template', [
                                     'items' => [
                                         self::getMainMenu(),
                                         self::getSiteMenu(),
                                         self::getLogoutMenu(),
                                     ],
                                 ]
        );
        
        $content = View:: factory(
            'Admin/Menu/Models', [
                                   'models' => Admin::scanModels(),
                               ]
        );
        $this->template->content = $menu . $content;
    }
    
    public function action_picker()
    {
        if ($this->check(['isAllowed'], ['getPickData']) === true)
        {
            
            $menuItems = [self::getMainMenu()];
            
            $menuItems[] = [
                'href'    => AdminHREF:: getFullCurrentHREF(),
                'caption' => $this->model->getCaption() . '&rarr; Изменение',
            ];
            
            $this->model->savePicks();
            
            $content = View::factory(
                'Admin/Data/Picker/Template', [
                                                'data' => $this->model->getPickData(),
                                            ]
            );
            
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function action_dataEdit()
    {
        if ($this->check(['isAllowed', 'isModifyingAllowed'], ['getEditData'], ['primary'], ['ref']) === true)
        {
            
            if (method_exists($this->model, 'editAction'))
            {
                $this->model->editAction($this->params['primary']);
            }
            
            $menuItems = [self::getMainMenu()];
            
            $menuItems[] = [
                'href'    => AdminHREF:: getFullCurrentHREF(),
                'caption' => $this->model->getCaption() . '&rarr; Редактирование',
            ];
            
            $content = View::factory(
                'Admin/Data/Edit/Template', [
                                              'model'  => $this->model,
                                              'params' => $this->params,
                                              'query'  => $this->query,
                                          ]
            );
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function action_uploadDescription()
    {
        $request = $this->request;
        if ($this->check(['isAllowed', 'isModifyingAllowed']) === true)
        {
            $post = $request->post();
            if (!empty($post) && !empty($post['file']) && !empty($post['description']))
            {
                Upload::setDescription($post['file'], $post['description']);
            }
        }
        
        $ref = $request->query('ref');
        
        if (!empty($ref))
        {
            Common::redirect($ref);
        }
        $this->goMenu();
    }
    
    public static function goMenu()
    {
        Common::redirect(AdminHREF::getDefaultAdminRouteUri('menu'));
    }
    
    public function action_uploadMakeFirst()
    {
        $request = $this->request;
        if ($this->check(['isAllowed', 'isModifyingAllowed']) === true)
        {
            $post = $request->post();
            if (!empty($post) && !empty($post['file']))
            {
                touch(mb_substr(DOCROOT, 0, -1) . $post['file']);
            }
        }
        
        $ref = $request->query('ref');
        
        if (!empty($ref))
        {
            Common::redirect($ref);
        }
        $this->goMenu();
    }
    
    public function action_dataOrder()
    {
        if ($this->check(['isAllowed'], ['getOrderData']) === true)
        {
            
            $menuItems = [self::getMainMenu()];
            
            $menuItems[] = [
                'href'    => AdminHREF:: getFullCurrentHREF(),
                'caption' => $this->model->getCaption() . '&rarr; Изменение',
            ];
            
            $orderData = $this->model->getOrderData();
            
            $this->saveOrder($orderData);
            
            $values = DB::select([$orderData['primary'], '`primary`'])
                        ->select([$orderData['column'], 'caption'])
                        ->select([$orderData['sortColumn'], 'number'])
                        ->from($orderData['table'])
                        ->order_by($orderData['sortColumn'])
                        ->order_by($orderData['column'])
                        ->execute()
                        ->as_array();
            
            $content = View::factory(
                'Admin/Data/Order/Template', [
                                               'values' => $values,
                                           ]
            );
            
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function saveOrder($orderData)
    {
        if (!empty($_POST) && !empty($_POST ['primaries']) && !empty($_POST ['numbers'])
            && is_array(
                $_POST ['primaries']
            )
            && is_array($_POST ['numbers'])
            && count($_POST ['primaries']) == count($_POST['numbers'])
        )
        {
            $params = array_combine($_POST['primaries'], $_POST['numbers']);
            
            if (!empty($_POST['reset']))
            {
                foreach ($params as $id => $number)
                {
                    $update = DB:: update($orderData['table'])
                                ->set([$orderData['sortColumn'] => 0])
                                ->where($orderData['primary'], '=', $id);
                    
                    if (!empty($orderData['conditions']))
                    {
                        foreach ($orderData['conditions'] as $condition)
                        {
                            $update = $update->and_where($condition[0], $condition[1], $condition[2]);
                        }
                    }
                    
                    $update->execute();
                }
            }
            else
            {
                foreach ($params as $id => $number)
                {
                    $update = DB:: update($orderData['table'])
                                ->set([$orderData['sortColumn'] => $number])
                                ->where($orderData['primary'], '=', $id);
                    
                    if (!empty($orderData['conditions']))
                    {
                        foreach ($orderData['conditions'] as $condition)
                        {
                            $update = $update->and_where($condition[0], $condition[1], $condition[2]);
                        }
                    }
                    
                    $update->execute();
                }
            }
        }
    }
    
    public function action_dataOrderSelect()
    {
        if ($this->check(['isAllowed'], ['getOrderData']) === true)
        {
            
            $menuItems = [self::getMainMenu()];
            
            $menuItems[] = [
                'href'    => AdminHREF:: getFullCurrentHREF(),
                'caption' => $this->model->getCaption() . '&rarr; Изменение порядка',
            ];
            
            $orderData = $this->model->getOrderData();
            $orderSelectData = $this->model->getOrderSelectData();
            
            $primary = $this->request->param('primary');
            
            if (empty($primary))
            {
                $content = View::factory(
                    'Admin/Data/Order/Select', [
                                                 'values'  => $orderSelectData['values'],
                                                 'caption' => $orderSelectData['selectCaption'],
                                             ]
                );
            }
            else
            {
                $this->saveOrder($orderData);
                
                $values = DB::select([$orderData['primary'], '`primary`'])
                            ->select([$orderData['column'], 'caption'])
                            ->select([$orderData['sortColumn'], 'number'])
                            ->from($orderData['table'])
                            ->order_by($orderData['sortColumn'])
                            ->order_by($orderData['column'])
                            ->where($orderSelectData['column'], '=', $primary);
                
                if (!empty($orderData['conditions']))
                {
                    foreach ($orderData['conditions'] as $condition)
                    {
                        $values = $values->and_where($condition[0], $condition[1], $condition[2]);
                    }
                }
                
                $values = $values->execute()
                                 ->as_array();
                
                $content = View::factory(
                    'Admin/Data/Order/Template', [
                                                   'values' => $values,
                                                   'ref'    => AdminHREF::getDefaultAdminRouteUri(
                                                       'dataOrderSelect', $this->model->getShortName()
                                                   ),
                                               ]
                );
            }
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function action_ajaxUploadsContent()
    {
        if ($this->check(
                [
                    'isAllowed',
                    'isModifyingAllowed',
                ], ['getEditData'], ['primary'], ['directoryIndex']
            ) === true
        )
        {
            
            $ref = false;
            if (!empty($_POST) && !empty($_POST['ref']))
            {
                $ref = $_POST['ref'];
            }
            
            echo View:: factory(
                'Admin/Data/Edit/Upload/List', [
                                                 'files'          => Model_Admin::getSharedModelUploads(
                                                     $this->model, $this->params['primary'],
                                                     $this->query['directoryIndex']
                                                 ),
                                                 'model'          => $this->model,
                                                 'ref'            => $ref,
                                                 'directoryIndex' => $this->query['directoryIndex'],
                                                 'params'         => $this->params,
                                                 'query'          => $this->query,
                                             ]
            );
        }
        
        die();
    }
    
    public function action_ajaxUploadDelete()
    {
        if ($this->check(
                [
                    'isAllowed',
                    'isModifyingAllowed',
                    'isDeletionAllowed',
                ], ['getEditData'], ['primary'], ['directoryIndex', 'file']
            ) === true
        )
        {
            $data = $this->model->getEditData($this->params['primary']);
            if (!empty($data) && !empty($data['uploadsDirs'])
                && !empty($data['uploadsDirs'][$this->query['directoryIndex']])
                && !in_array(mb_eregi_replace('\s', '', $this->query['file']), Admin::getProtectedUploadFilenames())
            )
            {
                $data = $data['uploadsDirs'][$this->query['directoryIndex']];
                $file = Admin:: getFullUploadsPath() . $data['directory'] . $this->query['file'];
                if (file_exists($file))
                {
                    ImagePreview::removePreviews($file);
                    unlink($file);
                }
            }
        }
        
        die();
    }
    
    public function action_dataDelete()
    {
        if ($this->check(
                [
                    'isAllowed',
                    'isModifyingAllowed',
                    'isDeletionAllowed',
                ], ['deleteData'], ['primary'], ['ref']
            ) === true
        )
        {
            
            $this->model->deleteData($this->params['primary']);
            Common::redirect($this->query['ref']);
        }
        self::goMenu();
    }
    
    public function action_dataInsert()
    {
        if ($this->check(['isAllowed', 'isModifyingAllowed'], ['getInsertColumns']) === true)
        {
            
            $menuItems = [self::getMainMenu()];
            $modelInfo = $this->model->getInfo();
            
            $menuItems[] = [
                'href'    => AdminHREF::getFullCurrentHREF(),
                'caption' => $this->model->getCaption() . '&rarr; Добавление',
            ];
            
            $insertData = $this->model->getInsertColumns();
            $table = $insertData['tableName'];
            $columns = $insertData ['columns'];
            
            $validate = function ()
            {
                return true;
            };
            
            if (isset($insertData['validate']) && is_callable($insertData ['validate']))
            {
                $validate = $insertData['validate'];
            }
            
            $uploadsDirs = [];
            if (!empty($insertData['uploadsDirs']))
            {
                $uploadsDirs = $insertData['uploadsDirs'];
            }
            
            $afterInsert = function ()
            {
                
            };
            if (isset($insertData['afterInsert']) && is_callable($insertData['afterInsert']))
            {
                $afterInsert = $insertData['afterInsert'];
            }
            
            $insert = function ($table, $post)
            {
                return DB::insert($table, array_keys($post))
                         ->values(array_values($post))
                         ->execute();
            };
            
            if (isset($insertData['insert']) && is_callable($insertData['insert']))
            {
                $insert = $insertData['insert'];
            }
            
            $message = null;
            $messageType = null;
            $post = [];
            if (!empty($_POST))
            {
                
                $message = 'Успешно добавлено';
                $messageType = 'success';
                $post = $_POST;
                
                if (isset($post['files']))
                {
                    unset($post['files']);
                }
                
                $valid = $validate($post);
                
                if ($valid === true)
                {
                    
                    try
                    {
                        
                        $insert = $insert($table, $post);
                        
                        $afterInsert($insert[0]);
                        
                        if (!empty($uploadsDirs))
                        {
                            $files = Admin::getPostFiles();
                            
                            foreach ($files as $directoryIndex => $fileItems)
                            {
                                if (!empty($uploadsDirs[$directoryIndex]))
                                {
                                    $uploadsDirs[$directoryIndex]['directory'] = str_replace(
                                        '<primary>', $insert[0], $uploadsDirs [$directoryIndex]['directory']
                                    );
                                    foreach ($fileItems as $file)
                                    {
                                        $this->upload($uploadsDirs[$directoryIndex], $file);
                                    }
                                }
                            }
                        }
                        
                        $post = [];
                    }
                    catch (Database_Exception $e)
                    {
                        $messageType = 'danger';
                        $message = 'При добавлении записи произошла ошибка:<br/><br/>' . $e->getMessage()
                                   . "<br/><br/>Исправьте ошибку и повторите попытку или обратитесь к администратору";
                    }
                }
                else
                {
                    $messageType = 'danger';
                    $message = $valid;
                }
            }
            
            $content = View::factory(
                'Admin/Data/Insert/Template', [
                                                'columns'     => $columns,
                                                'post'        => $post,
                                                'model'       => $this->model,
                                                'message'     => $message,
                                                'messageType' => $messageType,
                                                'uploadsDirs' => $uploadsDirs,
                                            ]
            );
            
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            
            $this->template->content = $menu . $content;
        }
    }
    
    public function upload($data, $file)
    {
        
        $maxSize = null;
        if (!empty($data['uploadMaxSize']) && is_numeric($data['uploadMaxSize']) && $data['uploadMaxSize'] > 0)
        {
            $maxSize = intval($data['uploadMaxSize']);
        }
        $allowedExtensions = null;
        if (!empty($data['allowedExtensions']))
        {
            $allowedExtensions = $data['allowedExtensions'];
        }
        
        $restrictedExtensions = null;
        if (!empty($data ['restrictedExtensions']))
        {
            $restrictedExtensions = $data ['restrictedExtensions'];
        }
        
        $allowNoExtension = null;
        if (!empty($data['allowNoExtension'])
            && ($data['allowNoExtension'] === true
                || $data['allowNoExtension'] === false)
        )
        {
            $allowNoExtension = $data['allowNoExtension'];
        }
        
        $postUpload = function ()
        {
            
        };
        if (!empty($data['postUpload']) && is_callable($data['postUpload']))
        {
            $postUpload = $data['postUpload'];
        }
        
        $fileExt = Admin::getFileExtension($file['name']);
        $path = Admin::getFullUploadsPath() . $data ['directory'];
        
        if (!empty($file ['tmp_name']) && $file ['error'] == 0
            && !in_array(
                $file ['name'], Admin::getRestrictedUploadFilenames()
            )
            && ($allowNoExtension === true || !empty($fileExt))
            && (empty($restrictedExtensions) || !Admin:: isFileHaveExt($file['name'], $restrictedExtensions))
            && (empty($allowedExtensions) || Admin::isFileHaveExt($file['name'], $allowedExtensions))
            && (is_null($maxSize) || $file['size'] <= $maxSize)
        )
        {
            
            Admin::createDirectoryIfNotExists($path);
            Admin::createHtaccessIfNotExist($path);
            $dest = Admin::getUploadFileName(
                $path . $file
                
                ['name']
            );
            copy($file['tmp_name'], $dest);
            
            unlink($file['tmp_name']);
            $postUpload($dest);
        }
    }
    
    public function action_crop()
    {
        if ($this->check(['isAllowed', 'isModifyingAllowed']) === true)
        {
            
            $modelInfo = $this->model->getInfo();
            $request = $this->request;
            if ($request->method() == 'POST')
            {
                $posts = $request->post();
                foreach ($posts as $file => $data)
                {
                    if (!empty($data))
                    {
                        $file = DOCROOT . mb_substr($file, 1, -4) . '.png';
                        $data = base64_decode(mb_substr($data, 22));
                        file_put_contents($file, $data);
                    }
                }
            }
            $content = View:: factory('Admin/Data/Edit/Upload/Crop');
            $this->template->content = $content;
        }
    }
    
    public function action_data()
    {
        if ($this->check(['isAllowed'], ['getData']) === true)
        {
            $menuItems = [self::getMainMenu()];
            $modelInfo = $this->model->getInfo();
            $menuItems[] = [
                'href'    => $this->model->getHREF(),
                'caption' => $this->model->getCaption(),
            ];
            
            if (method_exists($this->model, 'getInsertColumns'))
            {
                $menuItems[] = [
                    'href'    => AdminHREF:: getDefaultAdminRouteUri('dataInsert', $this->model->getShortName()),
                    'caption' => '<i class="fa fa-plus"></i> Добавить',
                ];
            }
            
            $content = View:: factory(
                'Admin/Data/Template', [
                                         'model' => $this->model,
                                     ]
            );
            $menuItems[] = self::getSiteMenu();
            $menuItems[] = self::getLogoutMenu();
            
            $menu = View:: factory('Admin/Menu/Template', ['items' => $menuItems]);
            $this->template->content = $menu . $content;
        }
    }
    
    public function action_ajaxUpload()
    {
        
        if ($this->check(
            [
                'isAllowed',
                'isModifyingAllowed',
            ], ['getEditData'], ['primary'], ['directoryIndex'], !empty($_FILES)
        )
        )
        {
            $editData = $this->model->getEditData($this->params['primary']);
            if (!empty($editData) && !empty($editData['uploadsDirs'])
                && !empty($editData['uploadsDirs'][$this->query['directoryIndex']])
            )
            {
                
                $editData = $editData['uploadsDirs'][$this->query['directoryIndex']];
                
                $file = array_shift($_FILES);
                
                $this->upload($editData, $file);
            }
        }
        
        die();
    }
    
    public function before()
    {
        parent::before();
        
        $this->auth = Auth:: instance();
        
        if (!$this->auth->logged_in() && $this->request->action() != 'auth' && $this->request->action() != 'register')
        {
            self::goAuth();
        }
    }
    
    public static function goAuth()
    {
        Common::redirect(AdminHREF::getDefaultAdminRouteUri('auth'));
    }
    
    public function action_index()
    {
        self::goMenu();
    }
    
    public function action_auth()
    {
        $login = $password = $error = '';
        $remember = false;
        
        if ($this->auth->logged_in())
        {
            self::goMenu();
        }
        
        if (!empty($_POST))
        {
            
            if (!empty($_POST['login']))
            {
                $login = $_POST['login'];
            }
            
            if (!empty($_POST['password']))
            {
                $password = $_POST['password'];
            }
            
            if (!empty($login) && !empty($password))
            {
                
                if (!empty($_POST['remember']) && $_POST['remember'] == 'on')
                {
                    $remember = true;
                }
                
                if ($this->auth->login($login, $password, $remember))
                {
                    $ref = Request::initial()
                                  ->query('ref');
                    if (!empty($ref))
                    {
                        Common::redirect($ref);
                    }
                    self::goMenu();
                }
                else
                {
                    $error = 'Неправильное имя пользователя или пароль. Попробуйте ещё раз.';
                }
            }
            else
            {
                if (empty($login))
                {
                    $error = 'Пустое имя пользователя.';
                }
                else
                {
                    $error = 'Пустой пароль';
                }
            }
        }
        
        $this->template->content = View:: factory(
            'Admin/Auth/Template', [
                                     'password' => $password,
                                     'remember' => $remember,
                                     'login'    => $login,
                                     'error'    => $error,
                                 ]
        );
    }
    
    public function action_register()
    {
        if (Common::config(['admin', 'SignInSignUp']))
        {
            $email = $password = $error = $captcha = '';
            
            if ($this->auth->logged_in())
            {
                self::goMenu();
            }
            
            if (!empty($_POST))
            {
                
                if (!empty($_POST['email']))
                {
                    $email = \Zver\StringHelper::load($_POST['email'])
                                               ->toHTMLEntities()
                                               ->get();
                }
                
                if (!empty($_POST['password']))
                {
                    $password = \Zver\StringHelper::load($_POST['password'])
                                                  ->toHTMLEntities()
                                                  ->get();
                }
                
                if (!empty($_POST['captcha']))
                {
                    $captcha = $_POST['captcha'];
                }
                
                if (!empty($email) && !empty($password) && !empty($captcha))
                {
                    
                    $exist = ORM::factory('User')
                                ->where('username', '=', $email)
                                ->find();
                    
                    if (!empty($exist->id))
                    {
                        $error = 'Пользователь с таким email уже существует. Введите другой email.';
                    }
                    elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
                    {
                        $error = 'Введите email правильно.';
                    }
                    elseif (!Captcha::valid($_POST['captcha']))
                    {
                        $error = 'Неправильно введен проверочный код.';
                    }
                    else
                    {
                        $success = false;
                        try
                        {
                            
                            $user = new Model_User();
                            $user->username = $email;
                            $user->email = $email;
                            $user->registered = date('Y-m-d H:i:s');
                            $user->password = $password;
                            $user->save();
                            
                            DB::insert('roles_users')
                              ->values(
                                  [
                                      'user_id' => $user->id,
                                      'role_id' => DB::select('id')
                                                     ->from('roles')
                                                     ->where('name', '=', 'user'),
                                  ]
                              )
                              ->execute();
                            
                            if ($this->auth->login($email, $password))
                            {
                                $success = true;
                            }
                            
                        }
                        catch (\Exception $e)
                        {
                            
                        }
                        
                        if ($success)
                        {
                            Admin::setMessage('Вы успешно зарегистрировались!', 'success');
                            self::goMenu();
                        }
                    }
                    
                }
                else
                {
                    if (empty($email))
                    {
                        $error = 'Введите email.';
                    }
                    elseif (empty($password))
                    {
                        $error = 'Введите пароль.';
                    }
                    else
                    {
                        $error = 'Введите проверочный код';
                    }
                }
            }
            
            $this->template->content = View:: factory(
                'Admin/Register/Template', [
                                             'password' => $password,
                                             'email'    => $email,
                                             'error'    => $error,
                                         ]
            );
        }
    }
    
    public function action_logout()
    {
        $this->auth->logout(true, true);
        self::goMenu();
    }
    
    public function action_loginuser()
    {
        $auth = Auth::instance();
        if ($auth->logged_in())
        {
            $roles = $auth->getRoles();
            if (in_array('admin', $roles))
            {
                $userId = Request::initial()
                                 ->param('primary');
                $auth->force_login(ORM::factory('User', $userId)->username);
                $this->goMenu();
            }
        }
        $this->goLogout();
    }
    
    public static function goLogout()
    {
        Common::redirect(AdminHREF:: getDefaultAdminRouteUri('logout'));
    }
    
}
