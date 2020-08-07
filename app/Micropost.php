<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    //
    protected $fillable = ['content'];


    /**
     * この投稿を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この投稿をいいね中のユーザー。（ Userモデルとの関係を定義）
     */
    public function favorite_users()
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
            var_dump($this->favorite_users()->attach($micropostId)); 

            $this->favorite_users()->attach($micropostId);
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
        $micropost = new Micropost();
        $userId = \Auth::id();
        // DB::enableQueryLog();
        // 確認したいSQL
        $articles = \Auth::user()->favorities()->where('micropost_id', $micropostId)->toSql();
        // dumpする
        var_dump($articles);
        // いいね中投稿の中に $micropostIdのものが存在するか
        $flag = \Auth::user()->favorities()->where('micropost_id', $micropostId)->exists();
        return $flag;
    }
}
