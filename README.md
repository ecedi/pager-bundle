# ecedi/pager-bundle by [Agence Ecedi](http://ecedi.fr)

This is a very old pager helper implementation. It predate [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) which is our prefered pager bundle thoses days

## installation

### edit your composer.json file and add

	{
		"require": {
			"ecedi/pager-bundle": "dev-master",
		},
		"repositories": [
		{
			"type": "vcs",
			"url": "https://github.com/ecedi/pager-bundle"
		}
		]
	}

### Add VarsBundle to your application kernel

	// app/AppKernel.php
	public function registerBundles()
	{
		return array(
			// ...
			new Ecedi\PagerBundle\EcediPagerBundle(),
			// ...
		);
	}


## Usage

in  a controller

	class MyController extends Controller {
		public function indexAction(Request $request) {
			// get pagination GET parameters from $ruest
        	$pager = $this->get('ecedi.pager');
        	$pager->setDefaultLimit(10);
        	$pager->bind($request->query);

        	// get a QueryBuilder
        	$qb = $this->getDoctrine()->getManager()->getRepository('MyBundle:Myentity')->findAllByName(); //it returns a QueryBuilder, not a Query

        	$qb
           		->setMaxResults($pager->getLimit())
           		->setFirstResult($pager->getOffset())
           	;
        	$query = $qb->getQuery();
        	$entitites = $query->getResult();

        	// pagination
        	$pager->setCount($count); //you have to manully run another query to find out the nbr of results
        	$pager->setCurrentCount(count($entities));
        	$pager->setArgs(array()); //this is an array of the route parameters to build urls in twig template


			return array(
            	'entities' => $entities,
            	'pager' => $pager,
			);
		}
	}


in a view

	{% include 'EcediPagerBundle:pager:prevnext.html.twig' with {'pager': page, 'route': 'a_route_name', 'anchor': 'an_anchor'} %}
