%global composer_vendor  fkooman
%global composer_project json

%global github_owner     fkooman
%global github_name      php-lib-json

Name:       php-%{composer_vendor}-%{composer_project}
Version:    1.0.0
Release:    2%{?dist}
Summary:    JSON convenience library written in PHP

Group:      System Environment/Libraries
License:    ASL 2.0
URL:        https://github.com/%{github_owner}/%{github_name}
Source0:    https://github.com/%{github_owner}/%{github_name}/archive/%{version}.tar.gz
Source1:    %{name}-autoload.php

BuildArch:  noarch

Provides:   php-composer(%{composer_vendor}/%{composer_project}) = %{version}

Requires:   php(language) >= 5.3.3
Requires:   php-json
Requires:   php-spl
Requires:   php-composer(symfony/class-loader)

BuildRequires:  php-composer(symfony/class-loader)
BuildRequires:  %{_bindir}/phpunit
BuildRequires:  %{_bindir}/phpab

%description
This is a PHP library written to make it easy and safe to process JSON.
It will throw exceptions when encoding or decoding fails.

%prep
%setup -qn %{github_name}-%{version}
cp %{SOURCE1} src/%{composer_vendor}/Json/autoload.php

%build

%install
mkdir -p ${RPM_BUILD_ROOT}%{_datadir}/php
cp -pr src/* ${RPM_BUILD_ROOT}%{_datadir}/php

%check
%{_bindir}/phpab --output tests/bootstrap.php tests
echo 'require "%{buildroot}%{_datadir}/php/%{composer_vendor}/Json/autoload.php";' >> tests/bootstrap.php
%{_bindir}/phpunit \
    --bootstrap tests/bootstrap.php

%files
%defattr(-,root,root,-)
%dir %{_datadir}/php/%{composer_vendor}/Json
%{_datadir}/php/%{composer_vendor}/Json/*
%doc README.md CHANGES.md composer.json
%license COPYING

%changelog
* Wed Sep 02 2015 François Kooman <fkooman@tuxed.net> - 1.0.0-2
- add autoloader
- run tests during build

* Mon Jul 13 2015 François Kooman <fkooman@tuxed.net> - 1.0.0-1
- update to 1.0.0

* Wed Oct 22 2014 François Kooman <fkooman@tuxed.net> - 0.6.0-1
- update to 0.6.0 

* Tue Sep 16 2014 François Kooman <fkooman@tuxed.net> - 0.5.1-1
- update to 0.5.1

* Tue Sep 16 2014 François Kooman <fkooman@tuxed.net> - 0.5.0-1
- update to 0.5.0

* Sun Aug 31 2014 François Kooman <fkooman@tuxed.net> - 0.4.1-1
- update to 0.4.1

* Fri Aug 29 2014 François Kooman <fkooman@tuxed.net> - 0.4.0-2
- use github tagged release sources
- update group to System Environment/Libraries

* Sat Aug 16 2014 François Kooman <fkooman@tuxed.net> - 0.4.0-1
- initial package
