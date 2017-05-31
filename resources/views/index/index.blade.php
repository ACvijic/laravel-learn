@extends('layouts.jango.layout')

@section('seo-title')
<title>Title</title>
@endsection

@section('content')
    <!-- BEGIN: PAGE CONTAINER -->
    <div class="c-layout-page">

        @include('layouts.jango.partials.breadcrumbs')
        <!-- BEGIN: PAGE CONTENT -->
        <!-- BEGIN: BLOG LISTING -->
        <div class="c-content-box c-size-md">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class="c-content-blog-post-1-view">
                            <?php
                            
                            /**
                             * First class for testing reflection
                             */
                            class A
                            {
                                public $one = '';
                                public $two = '';

                                //Constructor
                                public function __construct()
                                {
                                    //Constructor
                                }

                                //print variable one
                                public function echoOne()
                                {
                                    echo $this->one."\n";
                                }

                                //print variable two   
                                public function echoTwo()
                                {
                                    echo $this->two."\n";
                                }
                            }

                            //Instantiate the object
                            $a = new A();

                            //Instantiate the reflection object
                            $reflector = new ReflectionClass('A');

                            //Now get all the properties from class A in to $properties array
                            $properties = $reflector->getProperties();
                            $methods = $reflector->getMethods();

                            $i =1;
                            
                            echo "<pre>";
                            //Now go through the $properties array and populate each property
                            foreach($properties as $property)
                            {
                                //Populating properties
                                $a->{$property->getName()}=$i;
                                //Invoking the method to print what was populated
                                $a->{"echo".ucfirst($property->getName())}();
                                echo "<br>";
                                $i++;
                            }
                            
                            print_r($methods);
                            echo "</pre>";
                            ?>

                        </div>
                    </div>
                    
                    @include('layouts.jango.partials.sidebar')
                    
                </div>
            </div>
        </div>
        <!-- END: BLOG LISTING  -->
        <!-- END: PAGE CONTENT -->
    </div>
    <!-- END: PAGE CONTAINER -->
@endsection

@section('custom-js')

@endsection