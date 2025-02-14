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

/* themes/custom/gvventure_barrio/templates/layout/page.html.twig */
class __TwigTemplate_bc1249143e65421b6ba910eb18fa75d1 extends Template
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
            'head' => [$this, 'block_head'],
            'featured' => [$this, 'block_featured'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 71
        $context["sidebar_first_exists"] =  !Twig\Extension\CoreExtension::testEmpty(Twig\Extension\CoreExtension::trim(Twig\Extension\CoreExtension::striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 71)), "<img><video><audio><drupal-render-placeholder>")));
        // line 72
        $context["sidebar_second_exists"] =  !Twig\Extension\CoreExtension::testEmpty(Twig\Extension\CoreExtension::trim(Twig\Extension\CoreExtension::striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 72)), "<img><video><audio><drupal-render-placeholder>")));
        // line 73
        yield "
<div id=\"page-wrapper\">
  <div id=\"page\">
    <header id=\"header\" class=\"header kmm-container\" role=\"banner\" aria-label=\"";
        // line 76
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Site header"));
        yield "\">
      ";
        // line 77
        yield from $this->unwrap()->yieldBlock('head', $context, $blocks);
        // line 133
        yield "    </header>
    ";
        // line 134
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 134)) {
            // line 135
            yield "      <div class=\"highlighted\">
        <aside class=\"";
            // line 136
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true);
            yield " section clearfix\" role=\"complementary\">
          ";
            // line 137
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 137), "html", null, true);
            yield "
        </aside>
      </div>
    ";
        }
        // line 141
        yield "    ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 141)) {
            // line 142
            yield "      ";
            yield from $this->unwrap()->yieldBlock('featured', $context, $blocks);
            // line 149
            yield "    ";
        }
        // line 150
        yield "    <div id=\"main-wrapper\" class=\"layout-main-wrapper clearfix\">
      ";
        // line 151
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 178
        yield "    </div>
    ";
        // line 179
        if (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_first", [], "any", false, false, true, 179) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_second", [], "any", false, false, true, 179)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_third", [], "any", false, false, true, 179))) {
            // line 180
            yield "      <div class=\"featured-bottom\">
          ";
            // line 181
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_first", [], "any", false, false, true, 181), "html", null, true);
            yield "
          ";
            // line 182
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_second", [], "any", false, false, true, 182), "html", null, true);
            yield "
          ";
            // line 183
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_bottom_third", [], "any", false, false, true, 183), "html", null, true);
            yield "

      </div>
    ";
        }
        // line 187
        yield "    <footer class=\"site-footer\">
      ";
        // line 188
        yield from $this->unwrap()->yieldBlock('footer', $context, $blocks);
        // line 205
        yield "    </footer>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "container", "navbar_top_attributes", "container_navbar", "navbar_attributes", "navbar_collapse_btn_data", "navbar_collapse_class", "navbar_offcanvas", "directory", "sidebar_collapse", "content_attributes", "sidebar_first_attributes", "sidebar_second_attributes"]);        yield from [];
    }

    // line 77
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_head(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 78
        yield "        ";
        if (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 78) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "top_header", [], "any", false, false, true, 78)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 78))) {
            // line 79
            yield "          <nav";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["navbar_top_attributes"] ?? null), "addClass", ["naveg"], "method", false, false, true, 79), "html", null, true);
            yield " class=\"naveg\">
          ";
            // line 80
            if (($context["container_navbar"] ?? null)) {
                // line 81
                yield "          <div class=\"container\">
          ";
            }
            // line 83
            yield "              ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 83), "html", null, true);
            yield "
              ";
            // line 84
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "top_header", [], "any", false, false, true, 84), "html", null, true);
            yield "
              ";
            // line 85
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 85)) {
                // line 86
                yield "                <div class=\"form-inline navbar-form ms-auto\">
                  ";
                // line 87
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "top_header_form", [], "any", false, false, true, 87), "html", null, true);
                yield "
                </div>
              ";
            }
            // line 90
            yield "          ";
            if (($context["container_navbar"] ?? null)) {
                // line 91
                yield "          </div>
          ";
            }
            // line 93
            yield "          </nav>
        ";
        }
        // line 95
        yield "        ";
        if (((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 95) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 95)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 95))) {
            // line 96
            yield "          <nav";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["navbar_attributes"] ?? null), "html", null, true);
            yield ">
            ";
            // line 97
            if (($context["container_navbar"] ?? null)) {
                // line 98
                yield "            <div class=\"container\">
            ";
            }
            // line 100
            yield "              ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 100), "html", null, true);
            yield "
              ";
            // line 101
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 101) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 101))) {
                // line 102
                yield "                <button class=\"navbar-toggler collapsed\" type=\"button\" data-bs-toggle=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["navbar_collapse_btn_data"] ?? null), "html", null, true);
                yield "\" data-bs-target=\"#CollapsingNavbar\" aria-controls=\"CollapsingNavbar\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button>
                <div class=\"";
                // line 103
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["navbar_collapse_class"] ?? null), "html", null, true);
                yield "\" id=\"CollapsingNavbar\">
                  ";
                // line 104
                if (($context["navbar_offcanvas"] ?? null)) {
                    // line 105
                    yield "                    <div class=\"offcanvas-header\">
                      <button type=\"button\" class=\"btn-close text-reset\" data-bs-dismiss=\"offcanvas\" aria-label=\"Close\"></button>
                        <a href=\"";
                    // line 107
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("<front>"));
                    yield "\" class=\"offcanvas-logo\">
                          <img src=\"";
                    // line 108
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["directory"] ?? null), "html", null, true);
                    yield "/logo.svg\" width=\"96\" height=\"44\" alt=\"Logo\">
                        </a>
                    </div>
                    <div class=\"offcanvas-body\">
                  ";
                }
                // line 113
                yield "                  ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 113), "html", null, true);
                yield "
                  ";
                // line 114
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 114)) {
                    // line 115
                    yield "                    <div class=\"form-inline navbar-form justify-content-end\">
                      ";
                    // line 116
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header_form", [], "any", false, false, true, 116), "html", null, true);
                    yield "
                    </div>
                  ";
                }
                // line 119
                yield "                  ";
                if (($context["navbar_offcanvas"] ?? null)) {
                    // line 120
                    yield "                    </div>
                  ";
                }
                // line 122
                yield "                </div>
              ";
            }
            // line 124
            yield "              ";
            if (($context["sidebar_collapse"] ?? null)) {
                // line 125
                yield "                <button class=\"navbar-toggler navbar-toggler-left collapsed\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#CollapsingLeft\" aria-controls=\"CollapsingLeft\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"></button>
              ";
            }
            // line 127
            yield "            ";
            if (($context["container_navbar"] ?? null)) {
                // line 128
                yield "            </div>
            ";
            }
            // line 130
            yield "          </nav>
        ";
        }
        // line 132
        yield "      ";
        yield from [];
    }

    // line 142
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_featured(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 143
        yield "        <div class=\"featured-top\">
          <aside class=\"featured-top__inner section ";
        // line 144
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true);
        yield " clearfix\" role=\"complementary\">
            ";
        // line 145
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 145), "html", null, true);
        yield "
          </aside>
        </div>
      ";
        yield from [];
    }

    // line 151
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 152
        yield "        <div id=\"main\" class=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true);
        yield " p-0\">
          ";
        // line 153
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 153), "html", null, true);
        yield "
          <div class=\"row-offcanvas row-offcanvas-left clearfix\">
              <main";
        // line 155
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["content_attributes"] ?? null), "html", null, true);
        yield ">
                <section class=\"section\">
                  <a href=\"#main-content\" id=\"main-content\" tabindex=\"-1\"></a>
                  ";
        // line 158
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 158), "html", null, true);
        yield "
                </section>
              </main>
            ";
        // line 161
        if (($context["sidebar_first_exists"] ?? null)) {
            // line 162
            yield "              <div";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sidebar_first_attributes"] ?? null), "html", null, true);
            yield ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 164
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 164), "html", null, true);
            yield "
                </aside>
              </div>
            ";
        }
        // line 168
        yield "            ";
        if (($context["sidebar_second_exists"] ?? null)) {
            // line 169
            yield "              <div";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sidebar_second_attributes"] ?? null), "html", null, true);
            yield ">
                <aside class=\"section\" role=\"complementary\">
                  ";
            // line 171
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 171), "html", null, true);
            yield "
                </aside>
              </div>
            ";
        }
        // line 175
        yield "          </div>
        </div>
      ";
        yield from [];
    }

    // line 188
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_footer(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 189
        yield "        <div class=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["container"] ?? null), "html", null, true);
        yield " kmm-container\">
          ";
        // line 190
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 190) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 190)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 190)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 190))) {
            // line 191
            yield "            <div class=\"site-footer__top clearfix\">
              ";
            // line 192
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 192), "html", null, true);
            yield "
              ";
            // line 193
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 193), "html", null, true);
            yield "
              ";
            // line 194
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 194), "html", null, true);
            yield "
              ";
            // line 195
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 195), "html", null, true);
            yield "
            </div>
          ";
        }
        // line 198
        yield "          ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fifth", [], "any", false, false, true, 198)) {
            // line 199
            yield "            <div class=\"site-footer__bottom\">
              ";
            // line 200
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fifth", [], "any", false, false, true, 200), "html", null, true);
            yield "
            </div>
          ";
        }
        // line 203
        yield "        </div>
      ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/gvventure_barrio/templates/layout/page.html.twig";
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
        return array (  420 => 203,  414 => 200,  411 => 199,  408 => 198,  402 => 195,  398 => 194,  394 => 193,  390 => 192,  387 => 191,  385 => 190,  380 => 189,  373 => 188,  366 => 175,  359 => 171,  353 => 169,  350 => 168,  343 => 164,  337 => 162,  335 => 161,  329 => 158,  323 => 155,  318 => 153,  313 => 152,  306 => 151,  297 => 145,  293 => 144,  290 => 143,  283 => 142,  278 => 132,  274 => 130,  270 => 128,  267 => 127,  263 => 125,  260 => 124,  256 => 122,  252 => 120,  249 => 119,  243 => 116,  240 => 115,  238 => 114,  233 => 113,  225 => 108,  221 => 107,  217 => 105,  215 => 104,  211 => 103,  206 => 102,  204 => 101,  199 => 100,  195 => 98,  193 => 97,  188 => 96,  185 => 95,  181 => 93,  177 => 91,  174 => 90,  168 => 87,  165 => 86,  163 => 85,  159 => 84,  154 => 83,  150 => 81,  148 => 80,  143 => 79,  140 => 78,  133 => 77,  124 => 205,  122 => 188,  119 => 187,  112 => 183,  108 => 182,  104 => 181,  101 => 180,  99 => 179,  96 => 178,  94 => 151,  91 => 150,  88 => 149,  85 => 142,  82 => 141,  75 => 137,  71 => 136,  68 => 135,  66 => 134,  63 => 133,  61 => 77,  57 => 76,  52 => 73,  50 => 72,  48 => 71,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/gvventure_barrio/templates/layout/page.html.twig", "/var/www/html/web/themes/custom/gvventure_barrio/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 71, "block" => 77, "if" => 134];
        static $filters = ["trim" => 71, "striptags" => 71, "render" => 71, "t" => 76, "escape" => 136];
        static $functions = ["path" => 107];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'block', 'if'],
                ['trim', 'striptags', 'render', 't', 'escape'],
                ['path'],
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
