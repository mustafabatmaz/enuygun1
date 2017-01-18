<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BlogBundle\Entity\Posts;
use BlogBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }

	public function kanepeIndexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$post = $em->getRepository('BlogBundle:Posts')->findAll();

		return $this->render('BlogBundle:Default:indexKanepe.html.twig', array('yazilar' => $post));
	}

	public function newPostAction()
	{
		$new_post = new Posts();
		
		return $this->render('BlogBundle:Default:postForm.html.twig');
	}

	public function savePostAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$slug = $request->request->get('slug');
		$title = $request->request->get('title');
		$content = $request->request->get('content');

		$new_post = new Posts();
		$new_post->setslug($slug);
		$new_post->settitle($title);
		$new_post->setcontent($content);

		$em->persist($new_post);
		$em->flush();

		return $this->redirect($this->generateUrl('adminPanel'));
	}

	public function editPostAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		$post = $em->getRepository('BlogBundle:Posts')->findOneBy(array('slug' => $slug));

		return $this->render('BlogBundle:Default:editPost.html.twig', array('yazi' => $post));
	}

	public function updatePostAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$slug = $request->request->get('slug');
		$title = $request->request->get('title');
		$content = $request->request->get('content');

		$new_post = $em->getRepository('BlogBundle:Posts')->findOneBy(array('slug' => $slug));
		$new_post->setslug($slug);
		$new_post->settitle($title);
		$new_post->setcontent($content);

		$em->flush();

		return $this->redirect($this->generateUrl('adminPanel'));
	}

	public function deletePostAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$post = $em->getRepository('BlogBundle:Posts')->findOneBy(array('id' => $id));
		$em->remove($post);
		$em->flush();

		return $this->redirect($this->generateUrl('adminPanel'));
	}

	public function getPostAction()
	{
		$em = $this->getDoctrine()->getManager();
		$posts = $em->getRepository('BlogBundle:Posts')->findAll();

		return $this->render('BlogBundle:Default:getPost.html.twig', array('yazilar' => $posts));
	}

	public function postPageAction($slug)
	{
		$em = $this->getDoctrine()->getManager();
		$post = $em->getRepository('BlogBundle:Posts')->findOneBy(array('slug' => $slug));

		return $this->render('BlogBundle:Default:postPage.html.twig', array('yazi' => $post));
	}
}
