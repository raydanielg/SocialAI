<?php

namespace App\Helpers;

class PageHeader
{

    public ?string $title;
    public ?array $segments;
    public ?array $buttons;
    public ?array $overviews;
    public static ?self $instance = null;

    public function __construct(?string $title = null, ?array $segments = null, ?array $buttons = null, ?array $overviews = null)
    {
        $this->title = $title ?? '';
        $this->segments = $segments ?? request()->segments();
        $this->buttons = $buttons ?? [];
        $this->overviews = $overviews ?? [];
    }

    public static function set(string $title = '', array $segments = null, array $buttons = null, array $overviews = null): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($title, $segments, $buttons, $overviews);
        }
        return self::$instance;
    }

    public function title(string|array $title): self
    {
        $this->title = $title;
        return $this;
    }
    public function segments(array $segments): self
    {
        $this->segments = $segments;
        return $this;
    }

    public function buttons(array $buttons): self
    {
        array_push($this->buttons, ...$buttons);
        return $this;
    }

    public function overviews(array $overviews): self
    {
        $this->overviews = $overviews;
        return $this;
    }

    public static function button(string $name, ?string $url = '#', string $target = null): array
    {
        return [
            'name' => $name,
            'url' => $url,
            'target' => $target,
        ];
    }

    public static function toArray(): array
    {
        $thisIns = self::$instance ?? new static();

        return [
            'title' => $thisIns->title,
            'segments' => $thisIns->segments,
            'buttons' => $thisIns->buttons,
            'overviews' => $thisIns->overviews,
        ];
    }

    public function addLink(string $btnText = 'Button', string $url): self
    {
        $this->buttons[] = [
            'name' => $btnText,
            'url' => $url,
        ];
        return $this;
    }

    public function addModal(string $btnText, string $target)
    {
        $this->buttons[] = [
            'name' => $btnText,
            'toggle' => 'modal',
            'target' => $target,
        ];
        return $this;

    }

    public function dd(): self
    {
        dd(self::toArray());
        return $this;
    }
}