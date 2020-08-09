<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Micropost;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * このユーザが所有する投稿。（ Micropostモデルとの関係を定義）
     */
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }

    /**
     * このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    /**
     * このユーザをフォロー中のユーザ。（ Userモデルとの関係を定義）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    /**
     * $userIdで指定されたユーザをフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function follow($userId)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // すでにフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    /**
     * $userIdで指定されたユーザをアンフォローする。
     *
     * @param  int  $userId
     * @return bool
     */
    public function unfollow($userId)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // すでにフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }

    /**
     * 指定された $userIdのユーザをこのユーザがフォロー中であるか調べる。フォロー中ならtrueを返す。
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_following($userId)
    {
        // フォロー中ユーザの中に $userIdのものが存在するか
        return $this->followings()->where('follow_id', $userId)->exists();
    }

    public function feed_microposts()
    {
        // このユーザがフォロー中のユーザのidを取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Micropost::whereIn('user_id', $userIds);
    }

    /**
     * このユーザに関係するモデルの件数をロードする。
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'followings', 'followers', 'favorities']);
    }

    /**
     * このユーザがいいね中の投稿。（ Userモデルとの関係を定義）
     */
    public function favorities()
    {
        return $this->belongsToMany(Micropost::class, 'favorities', 'user_id', 'micropost_id')->withTimestamps();
    }
    
            /**
     * $micropostIdで指定された投稿をいいねする。
     *
     * @param  int  $micropostId
     * @return bool
     */
    public function favorite($micropostId)
    {
        // すでにいいねしているかの確認
        $exist = $this->is_favorite($micropostId);
        if ($exist) {
            // すでにいいねしていれば何もしない
            return false;
        } else {
            // 未いいねであればいいねする

            $this->favorities()->attach($micropostId);
            return true;
        }
    }

    /**
     * $micropostIdで指定された投稿のいいねを解除する。
     *
     * @param  int  $micropostId
     * @return bool
     */
    public function unfavorite($micropostId)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_favorite($micropostId);

        if ($exist) {
            // すでにフォローしていればフォローを外す
            $this->favorities()->detach($micropostId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }

    /**
     * 指定された $micropostIdの投稿をこのユーザがいいね中であるか調べる。フォロー中ならtrueを返す。
     *
     * @param  int  $micropostId
     * @return bool
     */
    public function is_favorite($micropostId)
    {
        // DB::enableQueryLog();
        // 確認したいSQL
        $articles = $this->favorities()->where('micropost_id', $micropostId)->toSql();
        // dumpする
        var_dump($articles);
        // いいね中投稿の中に $micropostIdのものが存在するか
        $flag = $this->favorities()->where('micropost_id', $micropostId)->exists();
        return $flag;
    }
}
