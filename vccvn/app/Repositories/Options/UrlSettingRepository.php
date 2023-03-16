<?php

namespace App\Repositories\Options;

// use App\Repositories\Base\BaseRepository;

class UrlSettingRepository extends SettingRepository
{

    
    /**
     * lấy thông tin input và data
     * @param string $group_slug
     * @param array $args
     * @return array
     */
    public function getUrlOptionItems($group_slug, array $args = [])
    {
        return $this->getOptionItems(
            array_merge($args, [
                'option' => 'urlsettings',
                'group' => $group_slug
            ])
        );
    }
    /**
     * get theme option data
     *
     * @param int $theme_id
     * @return array
     */
    public function getSettingData()
    {
        // lấy thông tin options
        $option = $this->getOptionGroupData(['slug' => 'urlsettings']);
        if ($option) {
            $optionGroups = [];
            if ($option->groups) {
                foreach ($option->groups as $i => $g) {
                    $config = $g->config ? (is_array($g->config) ? $g->config : json_encode($g->config, true)) : [];
                    $gdata = [
                        'slug' => $g->slug,
                        'label' => $g->label,
                        'id' => $g->id,
                        'inputs' => [],
                        'data' => [],
                        'config' => $config
                    ];
                    if ($g->datas) {
                        $inputs = [];
                        $data = [];
                        foreach ($g->datas as $d) {
                            $v = $d->value;
                            if ($d->type == 'checklist') {
                                $v = json_decode($v, true);
                            }
                            $props = $d->props;

                            $data[$d->name] = $v;
                            $dd = $d->toFormData();
                            unset($dd['props']);
                            $dd = array_merge($dd, $props);
                            $dd['id'] = $g->slug . '-' . $d->name;
                            unset($dd['value']);
                            $inputs[$d->name] = $dd;
                        }
                        $gdata['inputs'] = $inputs;
                        $gdata['data'] = $data;
                    }
                    $optionGroups[$g->slug] = $gdata;
                }
            }
            return $optionGroups;
        }
        return [];
    }

    
    /**
     * lưu option data
     * @param string $group_slug
     * @param array $data
     * @param array $args
     * @return array
     */
    public function updateUrlOptionData(string $group_slug, array $data = [], array $args = [])
    {
        return $this->updateOptionData(
            array_merge($args, [
                'option' => 'urlsettings',
                'group' => $group_slug
            ]),
            $data
        );
    }
}