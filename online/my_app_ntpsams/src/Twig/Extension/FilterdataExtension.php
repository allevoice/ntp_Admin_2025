<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\FilterdataRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FilterdataExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
//            new TwigFilter('filter_name', [FilterdataRuntime::class, 'doSomething']),
            new TwigFilter('filter_whyonsub', [FilterdataRuntime::class, 'whyonsub']),
            new TwigFilter('filter_array_listename', [FilterdataRuntime::class, 'array_listename']),
            new TwigFilter('filter_array_media_service', [FilterdataRuntime::class, 'array_media_service']),

            new TwigFilter('filter_lng_dataread', [FilterdataRuntime::class, 'lng_dataread']),
            new TwigFilter('filter_statuts_dataread', [FilterdataRuntime::class, 'statuts_dataread']),
			  new TwigFilter('filter_array_media_about', [FilterdataRuntime::class, 'array_media_about']),
            new TwigFilter('filter_array_service_info_liste', [FilterdataRuntime::class, 'array_service_info_liste']),

            new TwigFilter('filter_pageinfo', [FilterdataRuntime::class, 'pageinfo']),
            new TwigFilter('filter_pageinfomedia', [FilterdataRuntime::class, 'pageinfomedia']),
        ];
    }

    public function getFunctions(): array
    {
        return [
//            new TwigFunction('function_name', [FilterdataRuntime::class, 'doSomething']),
            new TwigFunction('func_whyonsub', [FilterdataRuntime::class, 'whyonsub']),
            new TwigFunction('func_array_listename', [FilterdataRuntime::class, 'array_listename']),
            new TwigFunction('func_array_media_service', [FilterdataRuntime::class, 'array_media_service']),

            new TwigFunction('func_lng_dataread', [FilterdataRuntime::class, 'lng_dataread']),
            new TwigFunction('func_statuts_dataread', [FilterdataRuntime::class, 'statuts_dataread']),
            new TwigFunction('func_array_media_about', [FilterdataRuntime::class, 'array_media_about']),
            new TwigFunction('func_array_service_info_liste', [FilterdataRuntime::class, 'array_service_info_liste']),

            new TwigFunction('func_pageinfo', [FilterdataRuntime::class, 'pageinfo']),
            new TwigFunction('func_pageinfomedia', [FilterdataRuntime::class, 'pageinfomedia']),
        ];
    }
}
