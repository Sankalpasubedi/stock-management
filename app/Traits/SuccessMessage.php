<?php


namespace App\Traits;

trait SuccessMessage
{
    public function getSuccessMessage($name)
    {
        return session()->flash('success', $name. ' created successfully.');
    }

    public function getUpdateSuccessMessage($name)
    {
        return session()->flash('update', $name . ' updated successfully.');
    }

    public function getDestroySuccessMessage($name)
    {
        return session()->flash('destroy', $name . ' removed successfully.');
    }

    public function getErrorMessage($msg)
    {
        return session()->flash('customError', $msg );
    }

    public function getTaskSuccessMessage($msg)
    {
        return session()->flash('success', $msg);
    }

}
