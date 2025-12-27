(function() {
  module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
      browserify: {
        dist: {
          options: {
            transform: [
              [
                'babelify', {
                  "presets": ["es2015"]
                }
              ]
            ]
          },
          files: {
            'dist/sweetalert.js': ['dev/sweetalert.es6.js']
          }
        }
      },
      less: {
        dist: {
          files: {
            'dist/sweetalert.css': 'lib/sweet-alert-combine.less'
          }
        }
      },
      wrap: {
        basic: {
          src: ['dist/sweetalert.js'],
          dest: '.',
          options: {
            wrapper: [';(function(window, document, undefined) {\n"use strict";\n', "/*\n * Use SweetAlert with RequireJS\n */\n\nif (typeof define === 'function' && define.amd) {\n  define(function () {\n    return sweetAlert;\n  });\n} else if (typeof module !== 'undefined' && module.exports) {\n  module.exports = sweetAlert;\n}\n\n})(window, document);"]
          }
        }
      },
      uglify: {
        dist: {
          files: {
            'dist/sweetalert.min.js': 'dist/sweetalert.js'
          }
        }
      },
      watch: {
        lib: {
          options: {
            livereload: 32123
          },
          files: ['**/*.{less,html,css}', 'dev/**/*.js'],
          tasks: ['compile']
        }
      },
      qunit: {
        all: ['test/index.html'],
        options: {
          timeout: 20000
        }
      },
      open: {
        example: {
          path: 'http://localhost:7777/'
        }
      },
      connect: {
        server: {
          options: {
            port: 7777,
            hostname: '*',
            base: '.'
          }
        }
      }
    });
    grunt.registerTask('compile', ['less', 'browserify', 'wrap', 'uglify']);
    grunt.registerTask('default', ['compile', 'connect', 'open', 'watch']);
    return grunt.registerTask('test', ['qunit']);
  };

}).call(this);
