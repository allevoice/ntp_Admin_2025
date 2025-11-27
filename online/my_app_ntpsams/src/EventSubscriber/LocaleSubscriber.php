<?php
// src/EventSubscriber/LocaleSubscriber.php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private string $defaultLocale;
    private array $supportedLocales;

    public function __construct(string $defaultLocale, array $supportedLocales)
    {
        $this->defaultLocale = $defaultLocale;
        $this->supportedLocales = $supportedLocales;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        // 1. Tente d'obtenir la locale à partir de l'URL (si la route a le paramètre {_locale})
        if ($localeFromRoute = $request->attributes->get('_locale')) {
            // S'assurer que la locale est supportée et la stocker en session
            if (in_array($localeFromRoute, $this->supportedLocales)) {
                $session->set('_locale', $localeFromRoute);
            }
        }

        // 2. Récupère la locale depuis la session, sinon utilise la locale par défaut
        $locale = $session->get('_locale', $this->defaultLocale);

        // 3. Définit la locale pour la requête (utilisée par le Translator)
        $request->setLocale($locale);
    }

    public static function getSubscribedEvents(): array
    {
        // La haute priorité (20) assure que la locale est définie avant le routing final
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
