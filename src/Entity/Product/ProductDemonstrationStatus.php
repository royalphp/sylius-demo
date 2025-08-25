<?php

namespace App\Entity\Product;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum ProductDemonstrationStatus: string implements TranslatableInterface
{
    final public const string TRANS_KEY = 'app.ui.statuses';

    case Requested = 'requested';
    case Handling = 'handling';
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('%s.%s', self::TRANS_KEY, $this->value), locale: $locale);
    }

    /**
     * @return string[]
     */
    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
