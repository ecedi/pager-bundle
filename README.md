# ecedi/pager-bundle by [Agence Ecedi](http://ecedi.fr)

This is a very old pager helper implementation. It predate KnpLabs/KnpPaginatorBundle which is our prefered pager bundle thoses days

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

@TODO
