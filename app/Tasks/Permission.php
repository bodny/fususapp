<?php

namespace Deployer;

desc('Change app:permissions');
task('app:permissions', function () {
    writeln('change permissions in {{deploy_path}}');

    run('find {{deploy_path}} -type d -exec chmod 0755 {} +');
    run('find {{deploy_path}} -type f -exec chmod 0644 {} +');

    writeln('change ownership to {{app_user}}:{{app_group}} in {{deploy_path}}');
    run('cd {{deploy_path}} && chown -Rf {{app_user}}:{{app_group}} current releases shared');
});
