#lock '3.6.1'

set :application, 'symfony3-material'
set :scm, :copy
#set :repo_url, 'git@bitbucket.org:nntuan/sym28.git'

#For Symfony 3
#set :linked_files, %w{app/config/parameters.yml}
set :linked_dirs, %w{var/logs vendor web/uploads/tmp web/uploads/banners web/uploads/avatars web/uploads/news web/uploads/page web/media}
set :file_permissions_paths, ["var/logs", "var/cache", "var/sessions", "web/uploads/tmp", "web/uploads/avatars",  "web/uploads/news", "web/uploads/page", "web/media"]

#For Symfony 2
#set :linked_dirs, %w{app/logs vendor}
#set :file_permissions_paths, ["app/logs", "app/cache"]

set :file_permissions_users, ["apache"]

set :format, :pretty
set :log_level, :debug
set :keep_releases, 5

before "deploy:updated", "deploy:set_permissions:acl"
after "deploy:updated", "deploy:set_permissions:chmod"
after 'deploy:starting', 'composer:install_executable'
#after 'deploy:updated', 'npm:install'   # remove it if you don't use npm
#after 'deploy:updated', 'bower:install' # remove it if you don't use bower
after 'deploy:updated', 'symfony:assets:install'
#after 'deploy:updated', 'symfony:assetic:dump'
