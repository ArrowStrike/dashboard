<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\test_todo;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $todo = new test_todo();
        $now = new\DateTime();


        $form = $this->createFormBuilder($todo)
            ->add(
                'name',
                TextType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'category',
                TextType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'priority',
                ChoiceType::class,
                array(
                    'choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High'),
                    'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'due_date',
                DateTimeType::class,
                array(
                    'data' => $now,
                    'attr' =>
                        array('style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'save',
                SubmitType::class,
                array(
                    'label' => 'Create Todo',
                    'attr' =>
                        array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                )
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Added'
            );

            return $this->redirectToRoute('todo');
        }


        return $this->render(
            '@App/Todo/create.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsAction($id)
    {


        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:test_todo')
            ->find($id);

        return $this->render(
            '@App/Todo/details.html.twig',
            array(
                'todo' => $todo,
            )
        );
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
            ->getRepository('AppBundle:test_todo')
            ->find($id);

        $now = new\DateTime('now');

        $todo->setName($todo->getName());
        $todo->setCategory($todo->getCategory());
        $todo->setDescription($todo->getDescription());
        $todo->setPriority($todo->getPriority());
        $todo->setDueDate($todo->getDueDate());
        $todo->setCreateDate($now);

        $form = $this->createFormBuilder($todo)
            ->add(
                'name',
                TextType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'category',
                TextType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'attr' =>
                        array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'priority',
                ChoiceType::class,
                array(
                    'choices' => array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High'),
                    'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'due_date',
                DateTimeType::class,
                array(
                    'attr' =>
                        array('style' => 'margin-bottom:15px'),
                )
            )
            ->add(
                'save',
                SubmitType::class,
                array(
                    'label' => 'Update Todo',
                    'attr' =>
                        array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                )
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Get Data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();


            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:test_todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);


            $em->flush();

            $this->addFlash(
                'notice',
                'Todo Updated'
            );

            return $this->redirectToRoute('todo');
        }

        return $this->render(
            '@App/Todo/edit.html.twig',
            array(
                'todo' => $todo,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/todo", name="todo")
     */
    public function indexAction()
    {
        $todos = $this->getDoctrine()
            ->getRepository('AppBundle:test_todo')
            ->findAll();

        return $this->render(
            '@App/Todo/index.html.twig',
            array(
                'todos' => $todos,
            )
        );

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('AppBundle:test_todo')->find($id);

        $em->remove($todo);
        $em->flush();

        $this->addFlash(
            'error',
            'Todo Removed'
        );

        return $this->redirectToRoute('todo');
    }

}
