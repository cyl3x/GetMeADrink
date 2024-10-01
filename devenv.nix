{ pkgs, lib, config, ... }:

let
  dbPort = toString config.services.mysql.settings.mysqld.port;
in {
  packages = [];

  dotenv.disableHint = true;

  languages.javascript = {
    enable = true;
    npm.enable = true;
  };

  languages.php = {
    enable = true;
    version = lib.mkDefault "8.2";
    extensions = [ "pcov" "xdebug" ];

    ini = ''
      memory_limit = 2G
      realpath_cache_ttl = 3600
      session.gc_probability = 0
      display_errors = On
      error_reporting = E_ALL
      opcache.memory_consumption = 256M
      opcache.interned_strings_buffer = 20
      zend.assertions = 0
      short_open_tag = 0
      zend.detect_unicode = 0
      realpath_cache_ttl = 3600
      ${lib.optionalString config.services.redis.enable ''
      session.save_handler = redis
      session.save_path = "tcp://127.0.0.1:${toString config.services.redis.port}/0"
      ''}
    '';

    fpm.pools.web = lib.mkDefault {
      settings = {
        "clear_env" = "no";
        "pm" = "dynamic";
        "pm.max_children" = 10;
        "pm.start_servers" = 2;
        "pm.min_spare_servers" = 1;
        "pm.max_spare_servers" = 10;
      };
    };
  };

  services.caddy = {
    enable = lib.mkDefault true;

    virtualHosts.":3000" = lib.mkDefault {
      extraConfig = lib.mkDefault ''
        handle /_vite_* {
          @websocket {
            header Connection *Upgrade*
            header Upgrade websocket
          }

          reverse_proxy localhost:${config.env.VITE_PORT}
          reverse_proxy @websocket localhost:${config.env.VITE_PORT}
        }

        @default {
          not path /assets/* /frontend/*
        }

        root * public
        php_fastcgi @default unix/${config.languages.php.fpm.pools.web.socket} {
          trusted_proxies private_ranges
        }
        file_server
      '';
    };
  };

  services.mysql = {
    enable = true;
    package = pkgs.mariadb_110;
    initialDatabases = lib.mkDefault [{ name = "getmeadrink"; }];
    ensureUsers = lib.mkDefault [
      {
        name = "getmeadrink";
        password = "getmeadrink";
        ensurePermissions = {
          "getmeadrink.*" = "ALL PRIVILEGES";
        };
      }
    ];
    settings = {
      mysqld = {
        log_bin_trust_function_creators = 1;
        port = lib.mkDefault 3309;
      };
    };
  };

  services.redis = {
    enable = true;
    port = lib.mkDefault 5687;
  };


  services.adminer = {
    enable = true;
    listen = "localhost:3001";
  };

  # Environment variables
  env.APP_URL = lib.mkDefault "http://localhost:3000";
  env.DATABASE_URL = lib.mkDefault "mysql://getmeadrink:getmeadrink@127.0.0.1:${dbPort}/getmeadrink";
  env.REDIS_URL = lib.mkDefault "redis://localhost:${toString config.services.redis.port}/1";
  env.VITE_PORT = lib.mkDefault "5154";
}
