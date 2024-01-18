<?php

namespace App\Library;

class Enum
{
    // Vite Resources Path
    public const LOGO_PATH = 'resources/images/logo.png';
    public const LOGO_WHITE_PATH = 'resources/images/logowhhite.png';
    public const NO_AVATAR_PATH = 'resources/images/no_avatar.png';
    public const NO_IMAGE_PATH = 'resources/images/noimage.jpg';
    public const LOGIN_BACKGROUND_PATH = 'resources/images/Background.jpg';
    public const CONFIG_IMAGE_DIR = 'storage/config';
    public const EMPLOYEE_PROFILE_IMAGE = 'storage/employee/profile';
    public const USER_AVATAR_DIR = 'storage/user/avatar';
    public const TICKET_ATTACHMENT_DIR = 'storage/ticket';
    public const ATTACHMENT_FILE_DIR = 'storage/attachment';
    public const FILE_ICON = 'resources/images/file-icon.png';
    public const EMPLOYEE_CONTACT_PERSION_IMAGE = 'storage/employee/contact';
    public const PROJECT_ID_TAG = 'Test';

    public const NEWS_FEATURE_IMAGE = 'storage/news';
    public const BLOG_FEATURE_IMAGE = 'storage/blog';
    public const MEDIA_VIDEO_DIR = 'storage/video';
    public const BROCHURE_FILE_DIR = 'storage/brochure';
    public const MAGAZINE_COVER_IMAGE_DIR = 'storage/magazine/cover_image';
    public const MAGAZINE_ATTACHMENT_DIR = 'storage/magazine/attachment';
    public const CLIENT_LOGO_DIR = 'storage/client_logo';
    public const CERTIFICATION_IMAGE_DIR = 'storage/certifications';
    public const AWARD_IMAGE_DIR = 'storage/awards';


    public const ROLE_SUPER_ADMIN_SLUG = 'super-admin';

    /* ============== USER TYPE MODULE ===================*/
    public const USER_TYPE_SUPER_ADMIN = 'super-admin';
    public const USER_TYPE_ADMIN = 'admin';
    public const USER_TYPE_EMPLOYEE = 'employee';
    public const USER_TYPE_CUSTOMER = 'customer';

    public static function getUserType(mixed $type = null)
    {
        $types = [
            self::USER_TYPE_SUPER_ADMIN   => 'Database User',
            self::USER_TYPE_ADMIN         => 'Admin',
            self::USER_TYPE_EMPLOYEE      => 'Employee',
            self::USER_TYPE_CUSTOMER      => 'Customer',
        ];

        if (is_array($type) && !empty($type)) {
            foreach ($type as $value) {
                $result[$value] = $types[$value];
            }

            return $result;
        }

        return $type ? $types[$type] : $types;
    }

    //===========------- Email Settings Start ----================//
    public const EMAIL_TICKET_CREATE = 'ticket_create';
    public const EMAIL_TICKET_ASSIGN = 'ticket_assign';
    public const EMAIL_TICKET_REPLY = 'ticket_reply';
    public const EMAIL_POST_CREATE = 'post_create';

    /* ============== TICKET MODULE ===================*/
    public const TICKET_STATUS_OPEN = 1;
    public const TICKET_STATUS_HOLD = 2;
    public const TICKET_STATUS_CLOSED = 3;
    public const TICKET_STATUS_NEW = 4;

    public static function getTicketStatus(int $status = null)
    {
        $status_arr = [
            self::TICKET_STATUS_OPEN   => 'Open',
            self::TICKET_STATUS_HOLD   => 'Hold',
            self::TICKET_STATUS_CLOSED => 'Closed',
            self::TICKET_STATUS_NEW    => 'New',
        ];

        return $status ? $status_arr[$status] : $status_arr;
    }

    public const TICKET_PRIORITY_LOW = 1;
    public const TICKET_PRIORITY_MEDIUM = 2;
    public const TICKET_PRIORITY_HIGH = 3;

    public static function getTicketPriority(int $priority = 0)
    {
        $priority_arr = [
            self::TICKET_PRIORITY_LOW    => "Low",
            self::TICKET_PRIORITY_MEDIUM => "Medium",
            self::TICKET_PRIORITY_HIGH   => 'High'
        ];

        return $priority ? $priority_arr[$priority] : $priority_arr;
    }

    /* ============== CONFIG MODULE ===================*/
    public const CONFIG_DROPDOWN_TICKET_DEPARTMENT = 'ticket_department';
    public const CONFIG_DROPDOWN_NOTIFICATION_TYPE = 'notification_type';
    public const CONFIG_DROPDOWN_GENDER = 'gender';
    public const CONFIG_DROPDOWN_JOB_TITLE = 'job_title';
    public const CONFIG_DROPDOWN_EMPLOYMENT_STATUS = 'employment_status';
    public const CONFIG_DROPDOWN_MEDIA_CATEGORY = 'media_category';
    public const CONFIG_DROPDOWN_CERTIFICATION_TYPE = 'certification_type';

    // public const CONFIG_DROPDOWN_BLOG_CATEGORY = 'blog_category';
    // public const CONFIG_DROPDOWN_BLOG_TAG = 'blog_tag';

    public static function getConfigDropdown(string $key = null)
    {
        $dropdowns = [
            self::CONFIG_DROPDOWN_TICKET_DEPARTMENT => "Ticket Issue Type",
            self::CONFIG_DROPDOWN_NOTIFICATION_TYPE => "Notification Type",
            self::CONFIG_DROPDOWN_GENDER            => "Gender",
            self::CONFIG_DROPDOWN_JOB_TITLE         => "Job Title",
            self::CONFIG_DROPDOWN_EMPLOYMENT_STATUS => "Employment Status",
            self::CONFIG_DROPDOWN_MEDIA_CATEGORY    => "Media Category",
            self::CONFIG_DROPDOWN_CERTIFICATION_TYPE=> "Certification Type",

            // self::CONFIG_DROPDOWN_BLOG_CATEGORY  => "Blog Category",
            // self::CONFIG_DROPDOWN_BLOG_TAG       => "Blog Tags",
        ];

        return $key ? $dropdowns[$key] : $dropdowns;
    }

    /* ============== END ===================*/

    public static function systemShortcodesWithValues()
    {
        return [
            'current_date'     => now()->format('Y-m-d'),
            'current_datetime' => '',
            'current_time'     => '',
            'system_url'       => '',
            'app_name'         => ''
        ];
    }

    /* ============== MEDIA TYPE MODULE ===================*/
    // public const MEDIA_TYPE_BLOG = 'blog';
    public const MEDIA_TYPE_NEWS = 'news';
    public const MEDIA_TYPE_VIDEO = 'video';
    public const MEDIA_TYPE_MAGAZINE = 'magazine';

    public static function getReferralDeclinedBy(string $type = null)
    {
        $types = [
            // self::MEDIA_TYPE_BLOG   => "Blog",
            self::MEDIA_TYPE_NEWS      => "News",
            self::MEDIA_TYPE_VIDEO     => "Video",
            self::MEDIA_TYPE_MAGAZINE  => "Magazine",
        ];

        return $type ? $types[$type] : $types;
    }

    /* ============== DEFAULT STATUS MODULE ===================*/
    public const STATUS_PENDING = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_INACTIVE = 3;

    public static function getStatus(string $type = null)
    {
        $types = [
            self::STATUS_PENDING  => "Pending",
            self::STATUS_ACTIVE   => "Active",
            self::STATUS_INACTIVE => "Inactive",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
}
