# 🧱 TASSILI - Laravel Inertia CRUD Generator

**TASSILI** is a full-featured CRUD generator package created by Rabah Douassi built with Laravel + Inertia.js + Vue 3. It comes with powerful tools such as Pinia for state management, Quill.js for rich text editing, and Chart.js for data visualization. Here is the web site https://tassili.dev/tassili-pro/docs/1.x/installation

---

## 📋 Requirements

- PHP `^8.2`
- Node.js and npm
- Laravel `^12` with Breeze (Inertia.js stack)
- Vite properly configured

---

## 🚀 Installation

### 1. Install Front-End Dependencies

```bash
npm install quill@^2.0.3
npm install vue-chartjs chart.js
npm install pinia
npm install notyf
npm install material-icons
composer require spatie/laravel-route-attributes
```

---
### 2. Update User Model
In your `App/Models/User.php`, add:

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
 {
   use HasRoles;
    ...
 }
```

---

### 3. Configure if you are not using typescript `resources/js/app.js`

```js
import '../css/app.css';
import './bootstrap';
import 'material-icons/iconfont/material-icons.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup: ({ el, App, props, plugin }) => {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .mount(el);
  },
  progress: {
    color: '#4B5563'
  }
});
```
---

### 3-b. Configure if you are using typescript `resources/js/app.ts` 

```js
import '../css/app.css';
import './bootstrap';
import 'material-icons/iconfont/material-icons.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp,DefineComponent,h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
  createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .mount(el);
  },
  progress: {
    color: '#4B5563'
  }
});
```

---

### 4. Storage Configuration (example for `public` disk)

```env
TASSILI_STORAGE_DISK=public
TASSILI_STORAGE_URL=http://127.0.0.1:8000/storage/
GUMROAD_TASSILI_LICENSE_KEY=YourTassiliGumroadKey 
```

---

### 5. Install Tassili

```bash
composer require tassili/prime
php artisan migrate
php artisan tassili:install
php artisan vendor:publish --tag=tassili-config
php artisan storage:link
```


---

### 6. Register Tassili Middleware

In your `bootstrap/app.php`, add:

```php
$middleware->alias([
    'tassili.auth' => \App\Http\Middleware\TassiliAuth::class,
]);
```
---

### 7. Update AppServiceProvider

In your `app/Providers/AppServiceProvider.php`, add:

```php
use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\RouteFileRegistrar;

 public function boot(): void
    {
        (new RouteRegistrar(Route::getFacadeRoot()))
    ->useRootNamespace('App\\Http\\Controllers') 
    ->useBasePath(app_path('Http/Controllers'))
    ->useMiddleware(['web'])
    ->registerDirectory(app_path('Http/Controllers'));

    }

```
---


## 🧩 Features

- 🎨 Inertia Vue 3 interface
- 🧠 State management with **Pinia**
- 📝 Rich text editing with **Quill.js**
- 📊 Charts with **Chart.js**
- ⚡️ Full **CRUD Generator**
- 🔒 Wizard Form System

---

## 📘 License

This project is licensed under a commercial license via [Gumroad](https://yazid4.gumroad.com/l/yyfte).

---

**Crafted with ❤️ by Rabah Douassi**