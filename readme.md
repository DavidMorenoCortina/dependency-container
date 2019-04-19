# Dependency container

This is a lite dependency container.


## Usage

It has a predefined **settings** dependency that must be provided when it's instantiate.


    $container = new Container([
        'db' => [
            'host' => 'localhost',
            'port' => 3306
        ]
    ]);
    
    $settings = $container['settings'];

To add custom dependencies:

    $container['someCustomName'] = function (Container $container){
        return new SomeCustomClass($container['settings']);
    };
    
    $someCustomName = $container['someCustomName'];


## License

[MIT License](https://opensource.org/licenses/MIT)

## Authors

 - David Moreno Cortina