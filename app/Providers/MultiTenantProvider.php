<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MultiTenantProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // dd($this->app->request->url());

        app()->bind('context', function(){
            $domain = explode(':',$this->app->request->getHttpHost())[0];
            $split_domain = explode('.', $domain);
            $subdomain = (sizeof($split_domain) <= 2 && !in_array("localhost", $split_domain)) ? "www" : $split_domain[0];
            $host = ($domain == 'localhost' or $domain == '127.0.0.1') ? 'localhost' : $split_domain[count($split_domain)-2];
            return $host == 'proptor' ? 'main' : 'prop';
        });

        
        
    //     $env = config()->get('app.env');
    //     $client = ($env == 'local') ? "test" : "main";
    //     $env = ($env == 'local') ? "test" : "live";
    //     Config::set(["client" => $client]);
    //     Config::set([ "env" => $env]);

    //     //get the domain
    //     $domain = $this->app->request->getHttpHost();

    //     //break the domain -- get sub, root and tld
    //     $split_domain = explode('.', $domain);

    //     //in root, it means no subdomain found e.g. example.com test.localhost
    //     $subdomain = (sizeof($split_domain) <= 2 && !in_array("localhost", $split_domain)) ? "www" : $split_domain[0];

    //     //From command prompt or default site
    //     if ($domain !== "localhost") {

    //         if ($subdomain === "test") {
    //             //Switch to test db
    //             DB::setDefaultConnection('test');
    //             Config::set(["client" => "test"]);
    //             Config::set(["env" => "test"]);
    //         }

    //         Config::set(["subdomain" => $subdomain]);


    //         $site_default_domains = array_map('reset', DB::select("select name from default_subdomains where status = 'running'"));

    //         //naming practice here is total offbar
    //         Config::set([ "site_domains" => $site_default_domains ]);

    //         //works in the case of sub.otherdomain.com but failed if sub.ngcart.com
    //         if (in_array($subdomain, $site_default_domains) && $domain !== "$subdomain.ngcart.com"){

    //             $domain = DB::table('domains')->whereDomainName($domain)->whereStatus('running')->first();
    //             if($domain) {
    //                 $store = DB::table('stores')->find($domain->store_id);
    //                 if($store->db_driver == 'sqlite'){
    //                     $params = [
    //                     'driver' => $store->db_driver,
    //                     'database' => $store->db_path,
    //                     ];
    //                 }
    //                 elseif($store->db_driver === null || $store->db_driver == 'mysql'){
    //                     $params = [
    //                     'driver' => 'mysql',
    //                     'host' => $store->db_host,
    //                     'port' => $store->db_port,
    //                     'username' => $store->db_username,
    //                     'password' => $store->db_password,
    //                     'database' => $store->db_database,
    //                     ];
    //                 }

    //                 Config::set(["client" => "store"]);

    //                 config()->set('database.connections.onthefly', $params);

    //                 DB::setDefaultConnection('onthefly');

    //                 DB::purge('onthefly');

    //                 DB::reconnect('onthefly');

    //             }else{
    //                 Config::set(["err"=>"store-404"]);
    //             }
    //         }

    //    }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
