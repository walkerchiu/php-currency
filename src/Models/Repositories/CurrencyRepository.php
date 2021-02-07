<?php

namespace WalkerChiu\Currency\Models\Repositories;

use Illuminate\Support\Facades\App;
use WalkerChiu\Core\Models\Forms\FormHasHostTrait;
use WalkerChiu\Core\Models\Repositories\Repository;
use WalkerChiu\Core\Models\Repositories\RepositoryHasHostTrait;

class CurrencyRepository extends Repository
{
    use FormHasHostTrait;
    use RepositoryHasHostTrait;

    protected $entity;
    protected $morphType;

    public function __construct()
    {
        $this->entity = App::make(config('wk-core.class.currency.currency'));
    }

    /**
     * @param String  $host_type
     * @param Int     $host_id
     * @param String  $code
     * @param Array   $data
     * @param Int     $page
     * @param Int     $nums per page
     * @param Boolean $is_enabled
     * @param String  $target
     * @param Boolean $target_is_enabled
     * @return Array
     */
    public function list($host_type, $host_id, String $code, Array $data, $page = null, $nums = null, $is_enabled = null, $target = null, $target_is_enabled = null)
    {
        $this->assertForPagination($page, $nums);

        if (empty($host_type) || empty($host_id)) {
            $entity = $this->entity;
        } else {
            $entity = $this->baseQueryForRepository($host_type, $host_id, $target, $target_is_enabled);
        }
        if ($is_enabled === true)      $entity = $entity->ofEnabled();
        elseif ($is_enabled === false) $entity = $entity->ofDisabled();

        $data = array_map('trim', $data);
        $records = $entity->with(['langs' => function ($query) use ($code) {
                                $query->ofCurrent()
                                      ->ofCode($code);
                             }])
                            ->when($data, function ($query, $data) {
                                return $query->unless(empty($data['id']), function ($query) use ($data) {
                                            return $query->where('id', $data['id']);
                                        })
                                        ->unless(empty($data['serial']), function ($query) use ($data) {
                                            return $query->where('serial', $data['serial']);
                                        })
                                        ->unless(empty($data['abbreviation']), function ($query) use ($data) {
                                            return $query->where('abbreviation', $data['abbreviation']);
                                        })
                                        ->unless(empty($data['mark']), function ($query) use ($data) {
                                            return $query->where('mark', $data['mark']);
                                        })
                                        ->unless(empty($data['exchange_rate']), function ($query) use ($data) {
                                            return $query->where('exchange_rate', $data['exchange_rate']);
                                        })
                                        ->when(isset($data['is_base']), function ($query) use ($data) {
                                            return $query->where('is_base', $data['is_base']);
                                        })
                                        ->unless(empty($data['name']), function ($query) use ($data) {
                                            return $query->whereHas('langs', function($query) use ($data) {
                                                $query->ofCurrent()
                                                      ->where('key', 'name')
                                                      ->where('value', 'LIKE', "%".$data['name']."%");
                                            });
                                        })
                                        ->unless(empty($data['description']), function ($query) use ($data) {
                                            return $query->whereHas('langs', function($query) use ($data) {
                                                $query->ofCurrent()
                                                      ->where('key', 'description')
                                                      ->where('value', 'LIKE', "%".$data['description']."%");
                                            });
                                        })
                                        ->unless(empty($data['remarks']), function ($query) use ($data) {
                                            return $query->whereHas('langs', function($query) use ($data) {
                                                $query->ofCurrent()
                                                      ->where('key', 'remarks')
                                                      ->where('value', 'LIKE', "%".$data['remarks']."%");
                                            });
                                        });
                              })
                            ->orderBy('updated_at', 'DESC')
                            ->get()
                            ->when(is_integer($page) && is_integer($nums), function ($query) use ($page, $nums) {
                                return $query->forPage($page, $nums);
                            });
        $list = [];
        foreach ($records as $record) {
            $data = $record->toArray();
            array_push($list,
                array_merge($data, [
                    'name'        => $record->findLangByKey('name'),
                    'description' => $record->findLangByKey('description'),
                    'remarks'     => $record->findLangByKey('remarks')
                ])
            );
        }

        return $list;
    }

    /**
     * @param Currency $entity
     * @param String|Array $code
     * @return Array
     */
    public function show($entity, $code)
    {
        $data = [
            'id' => $entity ? $entity->id : '',
            'basic' => []
        ];

        if (empty($entity))
            return $data;

        $this->setEntity($entity);

        if (is_string($code)) {
            $data['basic'] = [
                  'host_type'     => $entity->host_type,
                  'host_id'       => $entity->host_id,
                  'serial'        => $entity->serial,
                  'abbreviation'  => $entity->abbreviation,
                  'mark'          => $entity->mark,
                  'exchange_rate' => $entity->exchange_rate,
                  'is_base'       => $entity->is_base,
                  'name'          => $entity->findLang($code, 'name'),
                  'description'   => $entity->findLang($code, 'description'),
                  'remarks'       => $entity->findLang($code, 'remarks'),
                  'is_enabled'    => $entity->is_enabled,
                  'updated_at'    => $entity->updated_at
            ];

        } elseif (is_array($code)) {
            foreach ($code as $language) {
                $data['basic'][$language] = [
                      'host_type'     => $entity->host_type,
                      'host_id'       => $entity->host_id,
                      'serial'        => $entity->serial,
                      'abbreviation'  => $entity->abbreviation,
                      'mark'          => $entity->mark,
                      'exchange_rate' => $entity->exchange_rate,
                      'is_base'       => $entity->is_base,
                      'name'          => $entity->findLang($language, 'name'),
                      'description'   => $entity->findLang($language, 'description'),
                      'remarks'       => $entity->findLang($language, 'remarks'),
                      'is_enabled'    => $entity->is_enabled,
                      'updated_at'    => $entity->updated_at
                ];
            }
        }

        return $data;
    }

    /**
     * @param String $host_type
     * @param Int    $host_id
     * @param String $code
     * @return Array
     */
    public function getEnabledSetting($host_type, $host_id, String $code)
    {
        if (empty($host_type) || empty($host_id)) {
            $entity = $this->entity;
        } else {
            $entity = $this->baseQueryForRepository($host_type, $host_id);
        }
        $entity = $entity->ofEnabled();
        $records = $entity->with(['langs' => function ($query) use ($code) {
                                $query->ofCurrent()
                                      ->ofCode($code);
                             }])
                            ->orderBy('updated_at', 'DESC')
                            ->get();
        $list = [];
        foreach ($records as $record) {
            $list[$record->id] = ['id'            => $record->id,
                                  'abbreviation'  => $record->abbreviation,
                                  'mark'          => $record->mark,
                                  'exchange_rate' => $record->exchange_rate,
                                  'is_base'       => $record->is_base,
                                  'name'          => $record->findLangByKey('name')];
        }

        return $list;
    }

    /**
     * @param String $host_type
     * @param Int    $host_id
     * @return Array
     */
    public function getEnabledSettingId($host_type = null, $host_id = null)
    {
        if (empty($host_type) || empty($host_id)) {
            $entity = $this->entity;
        } else {
            $entity = $this->baseQueryForRepository($host_type, $host_id);
        }

        return $entity->ofEnabled()
                      ->orderBy('updated_at', 'DESC')
                      ->pluck('id')
                      ->toArray();
    }

    /**
     * @param String $host_type
     * @param Int    $host_id
     * @return Currency
     */
    public function getBaseSetting($host_type = null, $host_id = null)
    {
        if (empty($host_type) || empty($host_id)) {
            $entity = $this->entity;
        } else {
            $entity = $this->baseQueryForRepository($host_type, $host_id);
        }

        return $entity->ofBase()
                      ->first();
    }
}
