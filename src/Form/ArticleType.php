<?php
namespace App\Form;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//EntityType pour créer un champ de formulaire qui vous permettra de sélectionner la catégorie d'un article.
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder
->add('title', TextType::class)
->add('details', TextareaType::class, [
'attr' => ['rows' => 5]
])
->add('price', TextType::class)
->add('image', TextType::class)
->add('category', EntityType::class, [
    'class' => Category::class,
    'choice_label' => 'id'
]);}
}
