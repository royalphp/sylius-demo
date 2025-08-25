<?php

namespace App\Controller\Product;

use App\Entity\Product\ProductDemonstration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ProductDemonstrationController extends ResourceController
{
    public function toggleFeaturedAction(Request $request, TranslatorInterface $translator): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);

        /** @var ProductDemonstration $resource */
        $resource = $this->findOr404($configuration);

        if ($resource->getCompletedAt()) {
            $resource->setFeatured(!$resource->isFeatured());

            $this->manager->flush();

            $this->addFlash('success', $translator->trans('app.ui.success_toggle_featured'));
        } else {
            $this->addFlash('error', $translator->trans('app.ui.danger_toggle_featured'));
        }

        return $this->redirectHandler->redirectToResource($configuration, $resource);
    }
}
