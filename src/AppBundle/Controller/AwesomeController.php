<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AwesomeController extends Controller
{
    /**
     * @Route("/git", name="repository_root")
     * @Template()
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    public function rootAction(Request $request)
    {
        // Repository instance
        $repositories = $this->get('cypress_git_elephant.repository_collection');
        // There is also an handy alias
        $repositories = $this->get('git_repositories');
        // $repositories is an instance of GitElephant\Cypress\GitElephantBundle\Collection\GitElephantRepositoryCollection
        // it has the Countable, ArrayAccess and Iterator interfaces. So you can do:
        $num_repos = count($repositories); //number of repositories
        $git_elephant = $repositories->get('GitElephant'); // retrieve a Repository instance by its name (defined in config.yml)
        // iterate
        foreach ($repositories as $repo) {
            $repo->getLog();
        }
    }
}