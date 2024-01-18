<?php

namespace App\Library;

class Html
{
    public static function linkBack(string $route)
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary btn-back "><i class="fas fa-long-arrow-alt-left"></i> Back</a>';
    }

    public static function linkAdd(string $route, string $label, string $size = 'btn-sm')
    {
        return '<a href="' . $route . '" class="btn btn-sm btn2-secondary ' . $size . '"><i class="fas fa-plus"></i> ' . $label . '</a>';
    }

    public static function btnSubmit($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-secondary submitBtn ' . $size . '"><i class="fas fa-save"></i> Save</button>';
    }

    public static function btnReset()
    {
        return '<button type="reset" class="btn mr-3 my-3 btn2-light-secondary"><i class="fas fa-sync-alt"></i> Reset</button>';
    }

    public static function btnClose()
    {
        return '<button type="button" class="btn btn2-light-secondary mr-3 btn-close" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>';
    }

    public static function btnSignIN($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-secondary ' . $size . '"><i class="fa-solid fa-right-to-bracket"></i> Sign In </button>';
    }

    public static function btnSignOut($size = '')
    {
        return '<button type="submit" class="btn mr-3 my-3 btn2-danger-active ' . $size . '"><i class="fa-solid fa-right-from-bracket"></i> Sign Out </button>';
    }
}
