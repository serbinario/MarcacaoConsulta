<?php

namespace Seracademico\Providers;

use Illuminate\Support\ServiceProvider;

class SeracademicoRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            \Seracademico\Repositories\UserRepository::class,
            \Seracademico\Repositories\UserRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\RoleRepository::class,
            \Seracademico\Repositories\RoleRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\PermissionRepository::class,
            \Seracademico\Repositories\PermissionRepositoryEloquent::class
        );
		$this->app->bind(
			\Seracademico\Repositories\EstadoRepository::class,
			\Seracademico\Repositories\EstadoRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\CidadeRepository::class,
			\Seracademico\Repositories\CidadeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\BairroRepository::class,
			\Seracademico\Repositories\BairroRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\CategoriaCNHRepository::class,
			\Seracademico\Repositories\CategoriaCNHRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\CGMMunicipioRepository::class,
			\Seracademico\Repositories\CGMMunicipioRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EscolaridadeRepository::class,
			\Seracademico\Repositories\EscolaridadeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\NacionalidadeRepository::class,
			\Seracademico\Repositories\NacionalidadeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EstadoCivilRepository::class,
			\Seracademico\Repositories\EstadoCivilRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\SexoRepository::class,
			\Seracademico\Repositories\SexoRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\TipoEmpresaRepository::class,
			\Seracademico\Repositories\TipoEmpresaRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EnderecoCGMRepository::class,
			\Seracademico\Repositories\EnderecoCGMRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\CGMRepository::class,
			\Seracademico\Repositories\CGMRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\LocalidadeRepository::class,
			\Seracademico\Repositories\LocalidadeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\PostoSaudeRepository::class,
			\Seracademico\Repositories\PostoSaudeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EspecialidadeRepository::class,
			\Seracademico\Repositories\EspecialidadeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EspecialistaRepository::class,
			\Seracademico\Repositories\EspecialistaRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\CalendarioRepository::class,
			\Seracademico\Repositories\CalendarioRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\AgendamentoRepository::class,
			\Seracademico\Repositories\AgendamentoRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\EventoRepository::class,
			\Seracademico\Repositories\EventoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\OperacoeRepository::class,
			\Seracademico\Repositories\OperacoeRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\FilaRepository::class,
			\Seracademico\Repositories\FilaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\EspecialistaEspecialidadeRepository::class,
			\Seracademico\Repositories\EspecialistaEspecialidadeRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\MapaRepository::class,
			\Seracademico\Repositories\MapaRepositoryEloquent::class
		);
	}
}