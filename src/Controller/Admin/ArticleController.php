<?php

namespace PrestaShop\Module\MyBlog\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShop\Module\MyBlog\Form\ArticleFormDataProvider;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends FrameworkBundleAdminController
{
    public function createAction()
    {
        $this->get('prestashop.module.myblog.article.form_provider')->setIdArticle(null);

        $form = $this->get('prestashop.module.myblog.article.form_handler')->getForm();

        return $this->render('@Modules/myblog/views/templates/admin/article/create.html.twig',[
            'articleForm' => $form->createView()
        ]);
    }


    public function createProcessAction(Request $request)
    {
        return $this->processForm($request, 'Success.');
    }

    
    private function processForm(Request $request, $message, $articleId = null)
    {
        $formProvider = $this->get('prestashop.module.myblog.article.form_provider');
        $formProvider->setIdArticle($articleId);
        
        $formHandler = $this->get('prestashop.module.myblog.article.form_handler');
        $form = $formHandler->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $saveErrors = $formHandler->save($data);

            if (0 === count($saveErrors)) {
                $this->addFlash('success', $this->trans($successMessage, 'Admin.Notifications.Success'));

                return $this->redirectToRoute('create_article');
            }

            $this->flashErrors($saveErrors);
        }

        return $this->render('@Modules/myblog/views/templates/admin/article/create.html.twig',[
            'articleForm' => $form->createView()
        ]);
    }
}