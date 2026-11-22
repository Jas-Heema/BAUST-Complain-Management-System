<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintAttachment extends Model
{
    protected $fillable = ['complaint_id', 'file_path', 'original_name', 'mime_type', 'file_size'];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function getUrlAttribute(): string
    {
        $path = ltrim($this->file_path, '/');
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }
        return asset('storage/' . $path);
    }

    public function isImage(): bool
    {
        if ($this->mime_type && str_starts_with($this->mime_type, 'image/')) {
            return true;
        }

        $extension = strtolower(pathinfo($this->file_path ?: $this->original_name, PATHINFO_EXTENSION));
        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'], true);
    }

    public function getIsImageAttribute(): bool
    {
        return $this->isImage();
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    public function getExtensionAttribute(): string
    {
        return strtoupper(pathinfo($this->original_name ?: $this->file_path, PATHINFO_EXTENSION));
    }
}

