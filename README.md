# Kuhnian

Kuhnian is a continued refactoring of [Morten Rand-Hendriksen](https://mor10.com)'s Kuhn WordPress theme ([github.com/mor10/kuhn](https://github.com/mor10/kuhn)) that was designed to show what CSS Grid can do for WordPress theme layouts.

This refactoring is aimed at making the theme more easily customized by downstream users (e.g., child-theme developers and WordPress admins using just a custom-CSS plugin)—and more generally to demonstrate how themes in general can be made more easily customized by downstream users.

Step 1 of this refactoring is represented by the Kuhn-CSSvars theme [github.com/jimratliff/kuhn-cssvars](https://github.com/jimratliff/kuhn-cssvars), version 1.0.0, which refactored each then-existing Sass variable in Kuhn by defining a corresponding CSS variable, thus exposting the variable for customization by downstream users.

The current theme, Kuhnian, is the continuation of that process, starting where Kuhn-CSSvars left off. While Kuhn-CSSvars refactored all eligible *existing* Sass variables into having corresponding exposed CSS variables, Kuhnian looks for additional opportunities in Kuhn's/Kuhn-CSSvars' Sass code to define additional CSS variables from which downstream users would benefit.

## Licenses and External Assets
Kuhn-CSSvars is distributed under the terms of the GNU GPL v2

## Changelog

### 0.0.1 May 13, 2019
- Fork of Kuhn-CSSvars





