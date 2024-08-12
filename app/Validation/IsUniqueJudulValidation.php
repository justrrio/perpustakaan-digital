<?php

namespace App\Validation;

use App\Models\ModelBuku;

class IsUniqueJudulValidation
{
    public function checkJudul($value)
    {
        $modelBuku = new ModelBuku();
        $existingBook = $modelBuku
            ->where('judul', $value)
            ->where('deleted_at', null) // Check only non-deleted entries
            ->first();

        if (empty($existingBook)) {
            return true;
        } else {
            return false;
        }
    }
}
