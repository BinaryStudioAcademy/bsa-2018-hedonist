<?php

namespace Hedonist\Repositories\PasswordResetLink;


class PasswordResetLinkRepositpory
{
    public function addPasswordResetLink(string $email): string
    {
        //if valid link extists - no need to send another one
        if( $record = DB::table('password_resets')->where('email',$email)->first()!== null){
            if($this->checkValidResetLink($record)){
                throw new \Exception();
            }
        }

        $token =  str_random(16);
        DB::table('password_resets')->insert([
            'email' => $email,
            'token'=> $token,
            'created_at'=>Carbon::now()]);
        return $token;
    }

    private function checkValidResetLink(Model $record):bool //check if link is still active; L
    {
        $invalidate = Carbon::createFromFormat('YY-MM-DD HH:II:DD',$record->created_at)
            ->addHours(self::RESET_LINK_EXPIRE_HOURS)
            ->getTimestamp();
        $current = Carbon::now()->getTimestamp();
        if($current > $invalidate) {
            $record->delete();
            return false;
        }
        return true;

    }
}