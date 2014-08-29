%global composer_vendor  fkooman
%global composer_project json

%global github_owner     fkooman
%global github_name      php-lib-json

Name:       php-%{composer_vendor}-%{composer_project}
Version:    0.4.0
Release:    2%{?dist}
Summary:    JSON convenience library written in PHP

Group:      System Environment/Libraries
License:    ASL 2.0
URL:        https://github.com/%{github_owner}/%{github_name}
Source0:    https://github.com/%{github_owner}/%{github_name}/archive/%{version}.tar.gz
BuildArch:  noarch

Provides:   php-composer(%{composer_vendor}/%{composer_project}) = %{version}

Requires:   php >= 5.3.3

%description
This is a PHP library written to make it easy and safe to process JSON.
It will throw exceptions when encoding or decoding fails.

%prep
%setup -qn %{github_name}-%{version}

%build

%install
mkdir -p ${RPM_BUILD_ROOT}%{_datadir}/php
cp -pr src/* ${RPM_BUILD_ROOT}%{_datadir}/php

%files
%defattr(-,root,root,-)
%dir %{_datadir}/php/%{composer_vendor}/Json
%{_datadir}/php/%{composer_vendor}/Json/*
%doc README.md CHANGES.md COPYING composer.json

%changelog
* Fri Aug 29 2014 François Kooman <fkooman@tuxed.net> - 0.4.0-2
- use github tagged release sources
- update group to System Environment/Libraries

* Sat Aug 16 2014 François Kooman <fkooman@tuxed.net> - 0.4.0-1
- initial package