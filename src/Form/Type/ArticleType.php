<?php

namespace Prestashop\Module\MyBlog\Form\Type;

use PrestaShop\Module\MyBlog\Model\Article;
use PrestaShop\Module\MyBlog\Model\Category;
use PrestaShop\Module\MyBlog\Repository\CategoryRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleType extends AbstractType
{

    private $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class)
            ->add('preview', TextType::class)
            ->add('content', TextType::class)
            ->add('category', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => $this->categories,
                'choice_label' => function(?Category $cat) {
                    return $cat ? \strtoupper($cat->getName()): '';
                }
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }
}