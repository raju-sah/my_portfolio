<?php
use App\Models\HomeSetting;
$home_setting = HomeSetting::first();

?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('home') }}" class="app-brand-link">
            <span class="app-brand-text demo text-body fw-bolder text-uppercase">LOGO</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <x-sidebar-item route="{{ route('home') }}" name="Dashboard" uri="home">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
        </x-sidebar-item>

        <x-sidebar-multilist-head icon="bx bxs-report" name="Reports" :routes="[
            'Admin/article/reports',
            'Admin/article/filters',
        ]">
            <x-sidebar-item route="{{ route('admin.article-reports.index') }}" name="Article Report" uri="Admin/article/reports" />
            <x-sidebar-item route="{{ route('admin.article-reports.filters') }}" name="Filter Article" uri="Admin/article/filters" />
        </x-sidebar-multilist-head>
        

        <x-sidebar-item route="{{ route('admin.projects.index') }}" name="Projects" uri="Admin/projects">
            <i class="menu-icon tf-icons bx bxl-docker"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.skills.index') }}" name="Skills" uri="Admin/skills">
            <i class="menu-icon tf-icons bx bxl-stack-overflow"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.experiences.index') }}" name="Experiences" uri="Admin/experiences">
            <i class="menu-icon tf-icons bx bxs-buildings"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.backgrounds.index') }}" name=" Backgrounds" uri="Admin/backgrounds">
            <i class="menu-icon tf-icons bx bxs-institution"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.articles.index') }}" name="Articles" uri="Admin/articles">
            <i class="menu-icon tf-icons bx bxs-book-open"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.reviews.index') }}" name="Article Reviews" uri="Admin/reviews">
            <i class="menu-icon tf-icons bx bx-star"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.contacts.index') }}" name="Contacts" uri="Admin/contacts">
            <i class="menu-icon tf-icons bx bxs-contact"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.testimonials.index') }}" name="Testimonials" uri="Admin/testimonials">
            <i class="menu-icon tf-icons bx bxs-star"></i>
        </x-sidebar-item>
        <x-sidebar-item route="{{ route('admin.home-settings.edit', $home_setting->id) }}" name="Home Settings"
            uri="Admin/home-settings">
            <i class="menu-icon tf-icons bx bxs-cog"></i>
        </x-sidebar-item>

    </ul>
</aside>
