<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $fields)
 * @property mixed user_id
 */
class UserForum extends Model
{
    const USER_NORMAL = 0;
    const PRIVMSGS_NO_BOX = -3;
    const NOTIFY_EMAIL = 0;

    protected $connection = 'mysql_forum';
    protected $table = 'pbb_users';
    public $timestamps  = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'username_clean',
        'user_password',
        'user_email',
        'group_id',
        'user_type',
        'user_new',
        'user_permissions',
        'user_timezone',
        'user_dateformat',
        'user_lang',
        'user_style',
        'user_actkey',
        'user_ip',
        'user_regdate',
        'user_passchg',
        'user_options',
        'user_new',
        'user_inactive_reason',
        'user_inactive_time',
        'user_lastmark',
        'user_lastvisit',
        'user_lastpost_time',
        'user_lastpage',
        'user_posts',
        'user_colour',
        'user_avatar',
        'user_avatar_type',
        'user_avatar_width',
        'user_avatar_height',
        'user_new_privmsg',
        'user_unread_privmsg',
        'user_last_privmsg',
        'user_message_rules',
        'user_full_folder',
        'user_emailtime',
        'user_notify',
        'user_notify_pm',
        'user_notify_type',
        'user_allow_pm',
        'user_allow_viewonline',
        'user_allow_viewemail',
        'user_allow_massemail',
        'user_sig',
        'user_sig_bbcode_uid',
        'user_sig_bbcode_bitfield',
        'user_form_salt',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];

    /**
     * These are the additional vars able to be specified
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function GetAdditionalVars(){
        return array(
                'user_permissions'	=> '00000000000vzik0zi' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo' .
                                        ' m6b8xhqmx0qo',
                'user_timezone'		=> '',
                'user_dateformat'	=> 'D M d, Y g:i a',
                'user_lang'			=> 'en',
                'user_style'		=> 1, // TODO Change for method search default in data base (pbb_styles)
                'user_actkey'		=> '',
                'user_ip'			=> '',
                'user_regdate'		=> time(),
                'user_passchg'		=> time(),
                'user_options'		=> 230271,
                // We do not set the new flag here - registration scripts need to specify it
                'user_new'			=> 0,

                'user_inactive_reason'	=> 0,
                'user_inactive_time'	=> 0,
                'user_lastmark'			=> time(),
                'user_lastvisit'		=> 0,
                'user_lastpost_time'	=> 0,
                'user_lastpage'			=> '',
                'user_posts'			=> 0,
                'user_colour'			=> '',
                'user_avatar'			=> '',
                'user_avatar_type'		=> '',
                'user_avatar_width'		=> 0,
                'user_avatar_height'	=> 0,
                'user_new_privmsg'		=> 0,
                'user_unread_privmsg'	=> 0,
                'user_last_privmsg'		=> 0,
                'user_message_rules'	=> 0,
                'user_full_folder'		=> UserForum::PRIVMSGS_NO_BOX,
                'user_emailtime'		=> 0,

                'user_notify'			=> 0,
                'user_notify_pm'		=> 1,
                'user_notify_type'		=> UserForum::NOTIFY_EMAIL,
                'user_allow_pm'			=> 1,
                'user_allow_viewonline'	=> 1,
                'user_allow_viewemail'	=> 1,
                'user_allow_massemail'	=> 1,

                'user_sig'					=> '',
                'user_sig_bbcode_uid'		=> '',
                'user_sig_bbcode_bitfield'	=> '',

                'user_form_salt'			=> UserForum::unique_id(),
            );
    }

    /**
     * Return unique id
     * @throws \Exception
     */
    public static function unique_id()
    {
        return strtolower(UserForum::gen_rand_string(16));
    }

    /**
     * Generates an alphanumeric random string of given length
     *
     * @param int $num_chars Length of random string, defaults to 8.
     * This number should be less or equal than 64.
     *
     * @return string
     * @throws \Exception
     */
    private static function gen_rand_string($num_chars = 8)
    {
        $range = array_merge(range('A', 'Z'), range(0, 9));
        $size = count($range);

        $output = '';
        for ($i = 0; $i < $num_chars; $i++)
        {
            $rand = random_int(0, $size-1);
            $output .= $range[$rand];
        }

        return $output;
    }
}
