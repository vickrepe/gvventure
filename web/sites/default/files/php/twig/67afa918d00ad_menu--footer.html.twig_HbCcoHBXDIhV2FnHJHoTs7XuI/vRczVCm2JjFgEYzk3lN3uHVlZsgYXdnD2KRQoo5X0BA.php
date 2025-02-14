<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* themes/custom/gvventure_barrio/templates/navigation/menu--footer.html.twig */
class __TwigTemplate_4ac6ec0bf520847b1fb483daca4ae3ee extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 21
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("gvventure_barrio/menu-footer"), "html", null, true);
        yield "
";
        // line 22
        $macros["menus"] = $this->macros["menus"] = $this;
        // line 23
        yield "
";
        // line 28
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menus"]->getTemplateForMacro("macro_menu_links", $context, 28, $this->getSourceContext())->macro_menu_links(...[($context["items"] ?? null), ($context["attributes"] ?? null), 0]));
        yield "

";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["_self", "items", "attributes", "menu_level"]);        yield from [];
    }

    // line 30
    public function macro_menu_links($items = null, $attributes = null, $menu_level = null, ...$varargs): string|Markup
    {
        $macros = $this->macros;
        $context = [
            "items" => $items,
            "attributes" => $attributes,
            "menu_level" => $menu_level,
            "varargs" => $varargs,
        ] + $this->env->getGlobals();

        $blocks = [];

        return ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 31
            yield "\t";
            $macros["menus"] = $this;
            // line 32
            yield "\t";
            if (($context["items"] ?? null)) {
                // line 33
                yield "\t\t";
                if ((($context["menu_level"] ?? null) == 0)) {
                    // line 34
                    yield "\t\t\t<ul";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter(CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["navnavbar-nav"], "method", false, false, true, 34), "id"), "html", null, true);
                    yield ">
\t\t\t";
                } else {
                    // line 36
                    yield "\t\t\t\t<ul class=\"menu\">
\t\t\t\t";
                }
                // line 38
                yield "\t\t\t\t";
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 39
                    yield "\t\t\t\t\t";
                    // line 40
                    $context["classes"] = ["nav-item", ((CoreExtension::getAttribute($this->env, $this->source,                     // line 42
$context["item"], "is_expanded", [], "any", false, false, true, 42)) ? ("menu-item--expanded") : ("")), ((CoreExtension::getAttribute($this->env, $this->source,                     // line 43
$context["item"], "is_collapsed", [], "any", false, false, true, 43)) ? ("menu-item--collapsed") : ("")), ((CoreExtension::getAttribute($this->env, $this->source,                     // line 44
$context["item"], "in_active_trail", [], "any", false, false, true, 44)) ? ("active") : (""))];
                    // line 47
                    yield "\t\t\t\t\t<li";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 47), "addClass", [($context["classes"] ?? null)], "method", false, false, true, 47), "html", null, true);
                    yield ">
\t\t\t\t\t\t";
                    // line 49
                    $context["link_classes"] = ["nav-link", ((CoreExtension::getAttribute($this->env, $this->source,                     // line 51
$context["item"], "in_active_trail", [], "any", false, false, true, 51)) ? ("active") : ("")), ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,                     // line 52
$context["item"], "url", [], "any", false, false, true, 52), "getOption", ["attributes"], "method", false, false, true, 52), "class", [], "any", false, false, true, 52)) ? (Twig\Extension\CoreExtension::join(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 52), "getOption", ["attributes"], "method", false, false, true, 52), "class", [], "any", false, false, true, 52), " ")) : ("")), ("nav-link-" . \Drupal\Component\Utility\Html::getClass(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,                     // line 53
$context["item"], "url", [], "any", false, false, true, 53), "toString", [], "method", false, false, true, 53)))];
                    // line 56
                    yield "\t\t\t\t\t\t";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getLink(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 56), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 56), ["class" => ($context["link_classes"] ?? null)]), "html", null, true);
                    yield "
\t\t\t\t\t\t";
                    // line 57
                    if (CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 57)) {
                        // line 58
                        yield "\t\t\t\t\t\t\t";
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($macros["menus"]->getTemplateForMacro("macro_menu_links", $context, 58, $this->getSourceContext())->macro_menu_links(...[CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 58), ($context["attributes"] ?? null), (($context["menu_level"] ?? null) + 1)]));
                        yield "
\t\t\t\t\t\t";
                    }
                    // line 60
                    yield "\t\t\t\t\t</li>
\t\t\t\t";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 62
                yield "\t\t\t</ul>
\t\t";
            }
            // line 64
            yield "\t";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/gvventure_barrio/templates/navigation/menu--footer.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  141 => 64,  137 => 62,  130 => 60,  124 => 58,  122 => 57,  117 => 56,  115 => 53,  114 => 52,  113 => 51,  112 => 49,  107 => 47,  105 => 44,  104 => 43,  103 => 42,  102 => 40,  100 => 39,  95 => 38,  91 => 36,  85 => 34,  82 => 33,  79 => 32,  76 => 31,  62 => 30,  53 => 28,  50 => 23,  48 => 22,  44 => 21,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/gvventure_barrio/templates/navigation/menu--footer.html.twig", "/var/www/html/web/themes/custom/gvventure_barrio/templates/navigation/menu--footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["import" => 22, "macro" => 30, "if" => 32, "for" => 38, "set" => 40];
        static $filters = ["escape" => 21, "without" => 34, "join" => 52, "clean_class" => 53];
        static $functions = ["attach_library" => 21, "link" => 56];

        try {
            $this->sandbox->checkSecurity(
                ['import', 'macro', 'if', 'for', 'set'],
                ['escape', 'without', 'join', 'clean_class'],
                ['attach_library', 'link'],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
