[![Build Status](https://travis-ci.org/purcell/emacs.d.png?branch=master)](https://travis-ci.org/purcell/emacs.d)

# What you need to know about Emacs
Shortcut | Explanation
--- | ---
`C-x` | this means hold **Control** and push **x**
`M-w` | this means hold **Meta** and push **w**

Meta is sent by the terminal and is setup differently from terminal to terminal. In cases where terminal doesn't send meta, you have to tap once at escape to send meta-command, so no need to hold it down. In e.g. iTerm2 you have to set option-key to send meta.

#Basic shortcuts
Shortcut | Command
--- | ---
`C-x C-c` | Exit
`C-x C-s` | Save
`C-x C-f` | Open

# Cursor movement
Shortcut | Command
--- | ---
`C-f` | Move cursor forward
`C-b` | Move cursor backward
`C-n` | Move cursor down
`C-p` | Move cursor up
`C-n` | Move cursor down
`M-<` | Jump to start of buffer
`M->` | Jump to end of buffer
`C-v` | Scroll page down
`M-v` | Scroll page up

# Buffer managament
Shortcut | Command
--- | ---
`C-x b` | Jump to different open buffer
`C-x C-b`| Open ibuffer (to see open buffers)
`C-x k` | Kill buffer

# Window managament
Shortcut | Command
--- | ---
`C-x 2` | Split window horizontally
`C-x 3` | Split window vertically
`C-x 1` | Only show current window
`C-x 0` | Close current window

# Selection and copy/paste
Shortcut | Command
--- | ---
`C-space` | Start selection
`C-w` | Cut selection
`M-w` | Copy selection
`C-y` | Paste copy
`C-y M-y M-y` | Change paste to previous paste (cycle with `M-y`)
`C-x h` | Select all text in buffer

## Version control
Shortcut | Command
--- | ---
`C-x v d` | Open version control directory
`m` | Mark file
`u` | Unmark file
`i` | Add unregistered file
`+` | Update file (or directory)
`g` | Refresh view
`C-x v v` | Commit marked files
`C-c C-c` | Send commit (and push)

# My customization
* 4 spaces instead of tabs
* `color-theme-sanityinc-tomorrow-day`-theme
* Helm and Projectile
* Rebind `C-x C-f` to use Projectile find-file

# A reasonable Emacs config

This is my emacs configuration tree, continually used and tweaked
since 2000, and it may be a good starting point for other Emacs
users, especially those who are web developers. These days it's
somewhat geared towards OS X, but it is known to also work on Linux
and Windows.

Emacs itself comes with support for many programming languages. This
config adds improved defaults and extended support for the following:

* Ruby / Ruby on Rails
* CSS / LESS / SASS / SCSS
* HAML / Markdown / Textile / ERB
* Clojure (with Cider and nRepl)
* Javascript / Coffeescript
* Python
* PHP
* Haskell
* Erlang
* Common Lisp (with Slime)

In particular, there's a nice config for *tab autocompletion*, and
flycheck is used to immediately highlight syntax errors in Ruby, HAML,
Python, Javascript, PHP and a number of other languages.

## Requirements

* Emacs 24.3.1 or greater
* To make the most of the programming language-specific support in
  this config, further programs will likely be required, particularly
  those that [flycheck](https://github.com/flycheck/flycheck) uses to
  provide on-the-fly syntax checking.

## Installation

To install, clone this repo to `~/.emacs.d`, i.e. ensure that the
`init.el` contained in this repo ends up at `~/.emacs.d/init.el`:

```
git clone https://github.com/olekenneth/emacs.d.git ~/.emacs.d
```

Upon starting up Emacs for the first time, further third-party
packages will be automatically downloaded and installed. If you
encounter any errors at that stage, try restarting Emacs, and possibly
running `M-x package-refresh-contents` before doing so.



## Important note about `ido`

This config enables `ido-mode` completion in the minibuffer wherever
possible, which might confuse you when trying to open files using
<kbd>C-x C-f</kbd>, e.g. when you want to open a directory to use
`dired` -- if you get stuck, use <kbd>C-f</kbd> to drop into the
regular `find-file` prompt. (You might want to customize the
`ido-show-dot-for-dired` variable if this is an issue for you.)

## Updates

Update the config with `git pull`. You'll probably also want/need to update
the third-party packages regularly too:

<kbd>M-x package-list-packages</kbd>, then <kbd>U</kbd> followed by <kbd>x</kbd>.

## Adding your own customization

To add your own customization, use <kbd>M-x customize</kbd> and/or
create a file `~/.emacs.d/lisp/init-local.el` which looks like this:

```el
... your code here ...

(provide 'init-local)
```

If you need initialisation code which executes earlier in the startup process,
you can also create an `~/.emacs.d/lisp/init-preload-local.el` file.

If you plan to customize things more extensively, you should probably
just fork the repo and hack away at the config to make it your own!

## Similar configs

You might also want to check out `emacs-starter-kit` and `prelude`.

## Support / issues

If you hit any problems, please first ensure that you are using the latest version
of this code, and that you have updated your packages to the most recent available
versions (see "Updates" above). If you still experience problems, go ahead and
[file an issue on the github project](https://github.com/purcell/emacs.d).

-Steve Purcell

<hr>

[![](http://api.coderwall.com/purcell/endorsecount.png)](http://coderwall.com/purcell)

[![](http://www.linkedin.com/img/webpromo/btn_liprofile_blue_80x15.png)](http://uk.linkedin.com/in/stevepurcell)

[sanityinc.com](http://www.sanityinc.com/)

[@sanityinc](https://twitter.com/)
