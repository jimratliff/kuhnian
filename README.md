# Kuhn-CSSvars

Kuhn-CSSvars is a forked refactoring of [Morten Rand-Hendriksen](https://mor10.com)'s Kuhn WordPress theme [github.com/mor10/kuhn](https://github.com/mor10/kuhn). (The mission of Kuhn is to show what CSS Grid can do for WordPress theme layouts.)

## Mission
The mission of this refactoring is to illustrate how an existing theme using Sass variables can be refactored using CSS variables in order to make customization of the theme easier for either (a) a child-theme developer or (b) a WordPress admin using a custom-CSS plugin.

## Problem addressed
Sass variables aid a theme developer by allowing her to, for example, specify something (e.g., the value of a `font-size` property) once and reference it multiple times in her Sass code. In particular, this makes changes easier for the *theme developer*, who can just change the definition of a Sass variable and recompile in order to have the corresponding changes propagate through her code.

However, by the time a downstream consumer of the theme, e.g., a child-theme developer or a WordPress admin, receives the theme, the Sass variables have been compiled away, leaving `style.css` populated with the *values* of the variables, rather than the variables themselves. Thus a downstream consumer can't herself benefit from the ease of making site-wide changes that the theme developer enjoyed through the use of Sass variables.

The downstream consumer wanting to customize the theme for her child theme or website is faced with either of two unpleasant/undesirable options when, for example, she wants to change site-wide the value of a CSS property (e.g., the value of a `font-size` property):
- Try to target each occurrence where this property occurs in custom CSS specified via a custom-CSS plugin
  - This could require many additional CSS rules because selectors would have to account for possibly many combinations of elements, IDs, classes, and pseudo-classes implicated by the many locations in which the Sass variable assigned the value for this property
  - This would often require a lot of work and a lot of CSS sophistication to make sure that the newly specified CSS rules have sufficient specificity to override the rules in the parent theme.
- Make modifications to the parent theme itself. This is undesirable because:
  - It requires not just CSS knowledge but the sophistication and infrastructure to be able to recompile Sass code
  - Modifying the parent theme makes updating the parent theme more problematic, because you would overwrite your modifications.

## Solution
An existing theme that uses Sass variables can be fairly easily refactored to make customization of the theme much easier for a child-theme developer or a WordPress admin by creating a corresponding CSS variable for each Sass variable. The CSS variable will *not* be compiled away and will instead survive into the `style.css` file, making its overriding much easier.

Specifically:
1. For each eligible Sass variable that specifies a property value, define a corresponding CSS variable
2. Assign to the new CSS variable the value that was originally assigned to the Sass variable
3. Rewrite the definition of the Sass variable by assigning to it the value of the CSS variable

For example, suppose the following in `style.scss` (i.e., in the Sass code):
```
$color__background-button: #e6e6e6;
```
where `$color__background-button` is a Sass variable being assigned the color `#e6e6e6`.

When the Sass code is compiled into a `style.css` file, every button specification whose background color was specified by the `$color__background-button` Sass variable would look something like this:
```
.button {
    background-color: #e6e6e6;
}
```
In the refactored code, `$color__background-button: #e6e6e6;` would be replaced by:
```
--color__background-button: #e6e6e6;
$color__background-button: var(--color__background-button);
```
where (a) the first line defines the CSS variable `--color__background-button` and assigns the color to it and (b) the second line assigns to the Sass variable the value of the CSS variable.

Now, after compilation, the corresponding button specifications in `style.css` would look like:
```
.button {
    background-color: var(--color__background-button);
}
```
Note the the CSS variable `--color__background-button` has survived into the site's `style.css` file.

As a result of the refactoring, the downstream user could easily change the button background color by the rule:
```
:root {
    --color__background-button: magenta;
}
```

## Limitations
Not every use of a Sass variable can be replaced by a CSS variable in the above way.

In particular, you cannot use `var(--somecssvariable)`
- to represent a selector
- to represent a property *name* (representing a property *value* is fine)
- in the query part of a `@media` query; e.g., `@media ( min-width: var ( -- break-point-value))` does *not* work
- as an argument to the `url` function

(See Lea Verou, "[CSS Variables: `var(--subtitle)`,](https://www.youtube.com/watch?v=2an6-WVPuJU)" YouTube, October 5, 2016, starting at 2:23 and later at 8:05.)

## Usage
See the [wiki](https://github.com/jimratliff/kuhn-cssvars/wiki) for this repository, and specifically:
- [The correspondence between new CSS variables and original Sass variables](https://github.com/jimratliff/kuhn-cssvars/wiki/The-correspondence-between-new-CSS-variables-and-original-Sass-variables) for a table listing (a) the original Sass variable name, (b) the corresponding CSS variable name, and (c) the value associated with each Sass and/or CSS variable name.
- [Example custom CSS to change the formatting by assigning values to the CSS variable](https://github.com/jimratliff/kuhn-cssvars/wiki/Example-custom-CSS-to-change-the-formatting-by-assigning-values-to-the-CSS-variable/_edit) for an example of how to enter assignments of CSS variables in the custom-CSS field in the Admin panel or other custom-CSS plugin.


## Licenses and External Assets
Kuhn-CSSvars is distributed under the terms of the GNU GPL v2

## Changelog

### 0.0.1 May 13, 2019
- Fork of Kuhn

### 1.0.0 May 13, 2019
- Release of v. 1.0.0, the fully refactored version. No additional changes are anticipated, because my goal here was only to show how *existing* Sass variables can be supplemented with CSS variables. (I will fork *this* version, under a new name, and continue related refactoring to make customization by child-theme designers and WordPress admins easier.)



