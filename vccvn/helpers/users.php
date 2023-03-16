<?php

use App\Repositories\Profiles\ProfileRepository;
use App\Repositories\Users\UserRepository;
use App\Repositories\Notices\NoticeRepository;
use App\Repositories\Profiles\AcademicRepository;
use App\Repositories\Profiles\EducationRepository;
use App\Repositories\Profiles\WorkRepository;
use App\Repositories\Profiles\OrganizationRepository;
use App\Repositories\Profiles\ProfileSkillRepository;
use App\Repositories\Profiles\SkillRepository;
use App\Repositories\Profiles\WorkExperienceRepository;
use App\Repositories\Users\OwnerRepository;
use App\Repositories\Users\StaffRepository;
use Crazy\Helpers\Arr;


use App\Masks\Users\UserMask;
use Illuminate\Support\Facades\Auth;

if(!function_exists('set_logedin_user')){
    function set_logedin_user($user)
    {
        if($user){
            set_web_data('__logedin_user_login___', $user);
        }
    }
}
if(!function_exists('get_logedin_user')){
    function get_logedin_user()
    {
        if(!($user = get_web_data('__logedin_user_login___'))){
            if($u = auth()->user()){
                if($owner_id = get_owner_id()){
                    if(!($u->owner_id == $owner_id || $u->id == $owner_id)) return null;
                }
                $user = new UserMask($u);
                set_logedin_user($user);
                
            }else $user = null;
        }
        return $user;
    }
}

if(!function_exists('is_login')){
    /**
     * kiểm tra đăng nhap54 có hợp lệ ko
     *
     * @return boolean
     */
    function is_login()
    {
        if($user = auth()->user()){
            if($owner_id = get_owner_id()){
                if($user->owner_id == $owner_id || $user->id == $owner_id) return true;
                Auth::logout();
                return false;
            }
            return true;
        }
        return false;
    }
}

if(!function_exists('get_login_user')){
    /**
     * kiểm tra đăng nhập có hợp lệ ko và lấy thông tin user
     *
     * @return UserMask
     */
    function get_login_user()
    {
        return get_logedin_user();
    }
}
if(!function_exists('get_user_logedin')){
    /**
     * kiểm tra đăng nhập có hợp lệ ko và lấy thông tin user
     *
     * @return UserMask
     */
    function get_user_logedin()
    {
        return get_logedin_user();
    }
}

if(!function_exists('get_current_account')){
    /**
     * kiểm tra đăng nhập có hợp lệ ko và lấy thông tin user
     *
     * @return UserMask
     */
    function get_current_account()
    {
        return get_logedin_user();
    }
}


if(!function_exists('get_user_avatar')){
    /**
     * lấy dường dẫn avatar của người dùng
     * @param string $filename
     * @return string 
     */
    function get_user_avatar($filename = null){
        if($filename){
            return url('static/users/'.get_secret_id().'/avatar/'.$filename);
        }
        return asset('static/images/default/avatar.png');
    }
}

if(!function_exists('set_owner_id')){
    /**
     * thiet lap id owner dc active
     * @param int $owner_id
     * @return void
     */
    function set_profile_id(int $owner_id)
    {
        ProfileRepository::addOwnerID($owner_id);
    }
}

if(!function_exists('get_owner_id')){
    /**
     * lay owner id dc active
     * @param void
     * @return int $owner_id
     */
    function get_owner_id()
    {
        return ProfileRepository::getSettedOwnerID();
    }
}

if(!function_exists('get_owner')){
    /**
     * lấy tài khoản chủ web
     * 
     * @return App\Models\User|null
     */
    function get_owner()
    {
        static $owner = null;
        if(!$owner && $owner_id = get_owner_id()){
            if($user = (new OwnerRepository())->mode('mask')->getOwner()){
                $user->userWebSetting;
                $owner = $user;
            }
        }
        return $owner;
    }
}


if(!function_exists('get_owner_user')){
    /**
     * lấy tài khoản chủ web
     * 
     * @param int $id
     * 
     * @return App\Models\User|null
     */
    function get_owner_user($id = 0)
    {
        $id = $id ? $id : get_owner_id();
        if($id) return app(OwnerRepository::class)->mode('mask')->detail(['id'=>$id]);
        return null;
    }
}


if(!function_exists('get_owner_user__')){
    /**
     * lấy tài khoản chủ web
     * 
     * @param int $id
     * 
     * @return App\Models\User|null
     */
    function get_owner_user__($id = 0)
    {
        $id = $id ? $id : get_owner_id();
        if($id) return app(OwnerRepository::class)->select('secret_id')->detail(['id'=>$id]);
        return null;
    }
}




if(!function_exists('get_user')){
    /**
     * lấy tài khoản chủ web
     * 
     * @return App\Models\User|null
     */
    function get_user($args = null)
    {
        if(!$args) return null;

        $userRepository = app(UserRepository::class);

        if(is_array($args)) return $userRepository->first($args);

        if(is_numeric($args)) return $userRepository->findBy('id', $args);

        return null;
    }
}



if(!function_exists('get_secret_id')){
    /**
     * lấy thông tin secret_id
     * @param int $id
     * @return string
     */
    function get_secret_id($id = 0)
    {
        static $list = [];
        $uid = $id ? $id : get_owner_id();
        if(array_key_exists($uid, $list)) return $list[$uid];

        $secret_id = ($user = get_owner_user__($uid)) ? ($user->secret_id?$user->secret_id:$uid) : '0';
        $list[$uid] = $secret_id;
        return $secret_id;
    }
}

if(!function_exists('get_owner_client_key')){
    /**
     * lấy thông tin client_key
     * @param int $id
     * @return string
     */
    function get_owner_client_key($id = 0)
    {
        $secret_id = ($user = get_model_data('owner_user', $id ? $id : get_owner_id())) ? ($user->client_key?$user->client_key:$user->secret_id) : '0';
        return $secret_id;
    }
}

if(!function_exists('get_owner_secret_key')){
    /**
     * lấy thông tin get_user_client_key
     * @param int $id
     * @return string
     */
    function get_owner_secret_key($id = 0)
    {
        $secret_id = ($user = get_model_data('owner_user', $id ? $id : get_owner_id())) ? ($user->secret_key?$user->secret_key:$user->secret_id) : '0';
        return $secret_id;
    }
}


if(!function_exists('get_profile')){
    /**
     * lấy tài khoản chủ web
     * 
     * @return App\Models\User|null
     */
    function get_profile()
    {
        static $profile = null;
        if(!$profile){
            $profile = app(ProfileRepository::class)->getProfileInfo(get_owner_id());
        }
        return $profile;

    }
}


if(!function_exists('get_user_options')){
    /**
     * lấy user option
     * @param array $args
     * @param string $first
     * @param array $filter
     * @return array
     */
    function get_user_options($args = [], $first = null, $filter = null) : array
    {
        if(is_array($filter)){
            $args = Arr::match($args, $filter);
        }
        return (new UserRepository())->staffQuery()->getSelectOptions($args, $first);
    }
}
if(!function_exists('get_staff_options')){
    /**
     * lấy work option
     * @param array
     * @return array
     */
    function get_staff_options($args = [], $first = null) : array
    {
        return (new StaffRepository())->getSelectOptions($args, $first);
    }
}


if(!function_exists('get_user_notice_badge')){
    /**
     * trả về số thông báo mới
     * @param int $user_id
     * @return int
     */
    function get_user_notice_badge(int $user_id)
    {
        $metadata = new NoticeRepository();
        $b = $metadata->getBadge($user_id);
        return $b;
    }
}


if(!function_exists('get_academic_options')){
    /**
     * lấy academic option
     * @param array
     * @return array
     */
    function get_academic_options($args = []) : array
    {
        return (new AcademicRepository())->getOptions($args);
    }
}


if(!function_exists('get_work_options')){
    /**
     * lấy work option
     * @param array
     * @return array
     */
    function get_work_options($args = [], $first = null) : array
    {
        return (new WorkRepository())->getOptions($args, $first);
    }
}

if(!function_exists('get_profile_organization_options')){
    /**
     * lấy thông tin Tổ chức dưới dạng select option
     * @param array
     * @return array
     */
    function get_profile_organization_options($args = [], $first = "Tự do")
    {
        return (new OrganizationRepository())->getOptions($args, $first);
    }
}

if(!function_exists('get_profile_academic_options')){
    /**
     * lấy thông tin học vấn dưới dạng option
     * @param array
     * @return array
     */
    function get_profile_academic_options($args = [], $first = null)
    {
        return (new AcademicRepository())->getOptions($args, $first);
    }
}


if(!function_exists('get_skill_options')){
    /**
     * lấy thông tin kỹ năng dưới dạng select option
     * @param array
     * @return array
     */
    function get_skill_options($args = [])
    {
        return (new SkillRepository())->getOptions($args, "Chọn một");
    }
}

if(!function_exists('get_profile_skill_options')){
    /**
     * lấy thông tin kỹ năng dưới dạng select option
     * @param array
     * @return array
     */
    function get_profile_skill_options($args = [])
    {
        return app(ProfileSkillRepository::class)->getProfileSkillOptions($args);
    }
}

if(!function_exists('get_profile_skills')){
    /**
     * lấy thông tin kỹ năng dưới dạng select option
     * @param array
     * @return array
     */
    function get_profile_skills($args = [])
    {
        return app(ProfileSkillRepository::class)->getSkills($args);
    }
}




if(!function_exists('get_account_setting_configs')){
    /**
     * lấy danh sách trạng thái đơn hàng
     * @return array|Arr
     */
    function get_account_setting_configs()
    {
        return new Arr(array_map(function($a)
        {
            return new Arr($a);
        }, get_user_config('account_settings', [])));
    }
}

if(!function_exists('get_account_setting_tabs')){
    /**
     * lấy danh sách key trạng thái đơn hàng
     * @return array|Arr
     */
    function get_account_setting_tabs()
    {
        return new Arr(get_user_config('account_setting_tabs', []));
    }
}

// if(!function_exists('get_user_info_group_data')){
//     function get_user_info_group_data()
//     {
//         $info_groups = get_user_info_groups();
//         $info_keys = get_user_info_keys();
//         $group_data = [];
//         foreach ($info_keys as $key_vi => $key_en) {
//             $group_data[$key_en] = new Arr([
//                 'title' => $info_groups->get($key_en),
//                 'key' => $key_en,
//                 'slug' => $key_vi
//             ]);
//         }
//         return $group_data;
//     }
// }


if(!function_exists('get_experiences')){
    /**
     * lấy thông tin kinh nghiệm làm việc
     * @param array
     * @return \App\Masks\Examples\ExampleCollection
     */
    function get_experiences($args = [])
    {
        return app(WorkExperienceRepository::class)->getExperiences($args);
    }
}


if(!function_exists('get_educations')){
    /**
     * lấy thông tin kinh nghiệm làm việc
     * @param array
     * @return \App\Masks\Examples\ExampleCollection
     */
    function get_educations($args = [])
    {
        return app(EducationRepository::class)->getExperiences($args);
    }
}
