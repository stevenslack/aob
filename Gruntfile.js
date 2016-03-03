
module.exports = function(grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        header: {
            dist: {
                options: {
                    text: '/*\n' +
                            'Theme Name: Asheville on Bikes v2\n' +
                            'Theme URI: https://github.com/stevenslack/aob\n' +
                            'Author: Steven Slack\n' +
                            'Author URI: http://stevenslack.com\n' +
                            'Description: The Asheville on Bikes theme is a a fork of the Underscores.me starter theme from Automattic\n' +
                            'Version: 2.0\n' +
                            'License: GNU General Public License v2 or later\n' +
                            'License URI: http://www.gnu.org/licenses/gpl-2.0.html\n' +
                            'Text Domain: aob\n' +
                            'Tags:\n\n' +
                            'This theme, like WordPress, is licensed under the GPL.\n' +
                            'Use it to make something cool, have fun, and share what you\'ve learned with others.\n\n' +
                             'aob is based on Underscores http://underscores.me/, (C) 2012-2015 Automattic, Inc.\n' +
                            ' */\n',
                },
                files: {
                    'style.css' : 'style.css'
                }
            }
        },

        // sass
        sass: {
            options: {
                outputStyle: 'compressed',
                sourceMap: false
            },
            dist: {
                files: {
                    'style.css': 'assets/sass/style.scss',
                }
            },
            CSS: {
                files: {
                    'assets/css/editor-style.css': 'assets/sass/editor-style.scss',
                    'assets/css/ie8-style.css': 'assets/sass/ie8-style.scss',
                    'assets/css/login.css': 'assets/sass/login.scss',
                    'assets/css/critical.min.css' : 'assets/css/critical.css'
                }
            }
        },

        criticalcss: {
            custom_options: {
                options: {
                    url: "http://localhost/multisite/aob2/", // enter your localhost URL
                    width: 1200,
                    height: 900,
                    outputfile: "assets/css/critical.css",
                    filename: "style.css",
                    ignoreConsole: true
                }
            }
        },

        // autoprefixer
        autoprefixer: {

            multiple_files: {
                options: {
                    browsers: ['last 2 versions', 'ie 8', 'ie 9', 'ios 6', 'android 4'],
                    map: false
                },
                expand: true,
                flatten: true,
                src: 'assets/css/*.css',
                dest: 'assets/css/',
            },
            // prefix main file
            single_file: {
                options: {
                    browsers: ['last 2 versions', 'ie 8', 'ie 9', 'ios 6', 'android 4'],
                    map: false
                },
                src: 'style.css',
                dest: 'style.css'
            },
        },

        // // javascript linting with jshint
        // jshint: {
        //     options: {
        //         "force": true
        //     },
        //     all: [
        //         'Gruntfile.js',
        //         'assets/js/**/*.js'
        //     ]
        // },

        // uglify to concat, minify, and make source maps
        uglify: {
            options: {
                sourceMap: false
            },
            main: {
                files: {
                    'assets/js/main.js': [
                        'bower_components/fastclick/index.js',
                        'bower_components/astro/dist/js/astro.js',
                        'bower_components/drop/dist/js/drop.js',
                        'assets/js/components/skip-link-focus-fix.js',
                        'assets/js/components/init.js',
                    ],
                    'assets/js/html5.js' : [
                        'bower_components/html5shiv/dist/html5shiv.js'
                    ]
                }
            }
        },

        // image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: 'assets/img/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'assets/img/'
                }]
            }
        },

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['assets/sass/**/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer']
            },
            header: {
                files: 'style.css',
                tasks: ['header']

            },
            js: {
                files: 'assets/js/components/init.js',
                tasks: ['uglify']
            },
            images: {
                files: ['assets/img/**/*.{png,jpg,gif}'],
                tasks: ['imagemin']
            },
            livereload: {
                options: { livereload: true },
                files: ['style.css', 'assets/js/*.js', 'assets/img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

    });


    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-header');
    grunt.loadNpmTasks('grunt-criticalcss');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // register task
    grunt.registerTask( 'default', ['sass', 'autoprefixer', 'uglify', 'header', 'watch'] );

    grunt.registerTask( 'critical', ['criticalcss'] );
    grunt.registerTask( 'images', ['imagemin'] );

};
